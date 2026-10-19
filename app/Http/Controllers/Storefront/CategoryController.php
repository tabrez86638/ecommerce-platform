<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('storefront.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        abort_unless($category->is_active, 404);

        $products = Product::with(['category', 'brand', 'images'])
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        return view('storefront.categories.show', compact('category', 'products'));
    }
}
