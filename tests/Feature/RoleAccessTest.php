<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    private function userWithRole(string $role): User
    {
        return User::factory()->create(['role' => $role]);
    }

    public function test_guest_diarahkan_ke_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/posts')->assertRedirect('/login');
    }

    public function test_user_biasa_tidak_boleh_membuat_post(): void
    {
        $this->actingAs($this->userWithRole('user'))
            ->get('/posts/create')
            ->assertForbidden();
    }

    public function test_editor_boleh_membuat_dan_edit_post_sendiri(): void
    {
        $editor = $this->userWithRole('editor');
        $post = Post::factory()->create(['user_id' => $editor->id]);

        $this->actingAs($editor)->get('/posts/create')->assertOk();
        $this->actingAs($editor)->get("/posts/{$post->id}/edit")->assertOk();
    }

    public function test_editor_tidak_boleh_edit_post_orang_lain_atau_hapus(): void
    {
        $editor = $this->userWithRole('editor');
        $other  = Post::factory()->create(['user_id' => $this->userWithRole('admin')->id]);

        $this->actingAs($editor)->get("/posts/{$other->id}/edit")->assertForbidden();
        $this->actingAs($editor)->delete("/posts/{$other->id}")->assertForbidden();
    }

    public function test_admin_boleh_hapus_post_dan_buka_halaman_admin(): void
    {
        $admin = $this->userWithRole('admin');
        $post  = Post::factory()->create(['user_id' => $admin->id]);

        $this->actingAs($admin)->delete("/posts/{$post->id}")->assertRedirect('/posts');
        $this->actingAs($admin)->get('/admin/users')->assertOk();
    }

    public function test_non_admin_tidak_boleh_buka_halaman_admin(): void
    {
        $this->actingAs($this->userWithRole('editor'))->get('/admin/users')->assertForbidden();
        $this->actingAs($this->userWithRole('user'))->get('/admin/users')->assertForbidden();
    }
}
