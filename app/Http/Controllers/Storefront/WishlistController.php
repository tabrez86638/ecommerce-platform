<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = auth()->user()
            ->wishlists()
            ->with('product.images')
            ->latest()
            ->paginate(12);

        return view('storefront.wishlist.index', compact('wishlists'));
    }

    public function add(Request $request, Product $product)
    {
        if ($product->status !== 'published') {
            abort(404);
        }

        auth()->user()->wishlists()->firstOrCreate([
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Product added to your wishlist.');
    }

    public function remove(Request $request, Product $product)
    {
        auth()->user()
            ->wishlists()
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Product removed from your wishlist.');
    }
}