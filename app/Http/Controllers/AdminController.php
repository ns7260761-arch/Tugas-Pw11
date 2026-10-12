<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::orderBy('role')->orderBy('name')->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(['admin', 'editor', 'user'])],
        ]);

        if ($user->is($request->user())) {
            return back()->withErrors(['role' => 'Tidak bisa mengubah role akun sendiri.']);
        }

        $user->update($data);

        return back()->with('status', "Role {$user->name} diubah menjadi {$data['role']}.");
    }

    /** Bonus: demo eager loading (bandingkan jumlah query). */
    public function eagerLoading()
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        Product::take(20)->get()->each(fn ($p) => $p->category->name);   // N+1
        $lazy = count(DB::getQueryLog());

        DB::flushQueryLog();
        Product::with('category')->take(20)->get()->each(fn ($p) => $p->category->name);
        $eager = count(DB::getQueryLog());

        DB::disableQueryLog();

        return response()->json([
            'tanpa_eager_loading' => $lazy . ' query',
            'dengan_with_category' => $eager . ' query',
        ]);
    }
}
