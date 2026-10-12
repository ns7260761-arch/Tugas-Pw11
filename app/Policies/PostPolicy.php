<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

/**
 * Aturan otorisasi untuk Post.
 *  - semua user login boleh melihat daftar
 *  - admin & editor boleh membuat
 *  - admin boleh edit semua; editor hanya edit post miliknya
 *  - hanya admin yang boleh menghapus
 */
class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function update(User $user, Post $post): bool
    {
        return $user->isAdmin()
            || ($user->isEditor() && $post->user_id === $user->id);
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }
}
