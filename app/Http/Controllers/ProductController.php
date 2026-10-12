<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /** Halaman publik: daftar produk aktif (eager loading kategori). */
    public function index(Request $request)
    {
        $products = Product::with('category')           // eager loading -> hindari N+1
            ->active()
            ->search($request->query('q'))
            ->when($request->query('category'), function ($query, $slug) {
                $query->whereHas('category', fn ($c) => $c->where('slug', $slug));
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }
}
