<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
public function index(Request $request)
{
    $search = trim($request->input('search', ''));
    $categoryId = $request->input('category');
    $brandId = $request->input('brand');

    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');

    $sort = $request->input('sort', 'newest');

    $allowedSorts = [
        'newest',
        'price_low',
        'price_high',
    ];

    if (!in_array($sort, $allowedSorts, true)) {
        $sort = 'newest';
    }

    $categories = \App\Models\Category::where('is_active', true)
        ->orderBy('name')
        ->get();

    $brands = \App\Models\Brand::where('is_active', true)
        ->orderBy('name')
        ->get();

    $productsQuery = Product::with(['category', 'brand', 'images'])
        ->where('status', 'published')
        ->when($search !== '', function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        })
        ->when($categoryId, function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })
        ->when($brandId, function ($query) use ($brandId) {
            $query->where('brand_id', $brandId);
        })
        ->when($minPrice !== null && $minPrice !== '', function ($query) use ($minPrice) {
            $query->where('price', '>=', $minPrice);
        })
        ->when($maxPrice !== null && $maxPrice !== '', function ($query) use ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        });

    switch ($sort) {
        case 'price_low':
            $productsQuery->orderBy('price', 'asc');
            break;

        case 'price_high':
            $productsQuery->orderBy('price', 'desc');
            break;

        default:
            $productsQuery->latest();
            break;
    }

    $products = $productsQuery
        ->paginate(12)
        ->withQueryString();

    return view('storefront.products.index', compact(
        'products',
        'search',
        'categories',
        'categoryId',
        'brands',
        'brandId',
        'minPrice',
        'maxPrice',
        'sort'
    ));
}


    public function show(string $slug)
    {
        $product = Product::with([
            'category',
            'brand',
            'variants.attributeValues.attribute',
            'variants.images',
            'images',
            'reviews.user',
        ])->where('slug', $slug)->firstOrFail();

        return view('storefront.products.show', compact('product'));
    }
}