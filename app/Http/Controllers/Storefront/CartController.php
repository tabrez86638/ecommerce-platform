<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        $products = [];

        if (!empty($cart)) {
            $productIds = array_keys($cart);

            $products = Product::whereIn('id', $productIds)
                ->where('status', 'published')
                ->get()
                ->keyBy('id');
        }

        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            if (isset($products[$productId])) {
                $price = $products[$productId]->sale_price
                    ?? $products[$productId]->price;

                $subtotal += $price * $item['quantity'];
            }
        }

        return view('storefront.cart.index', [
            'cart' => $cart,
            'products' => $products,
            'subtotal' => $subtotal,
            'total' => $subtotal,
        ]);
    }

    /**
     * Add a product to the cart.
     */
    
public function add(Request $request, Product $product)
{
    if ($product->status !== 'published') {
        abort(404);
    }

    $validated = $request->validate([
        'quantity' => ['sometimes', 'required', 'integer', 'min:1', 'max:99'],
    ]);

    $quantity = (int) ($validated['quantity'] ?? 1);

    $cart = $request->session()->get('cart', []);

    $productId = $product->id;

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $quantity;
    } else {
        $cart[$productId] = [
            'quantity' => $quantity,
        ];
    }

    $request->session()->put('cart', $cart);

    return redirect()
        ->route('cart.index')
        ->with('success', 'Product added to cart successfully.');
}

    /**
     * Update product quantity.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $request->session()->get('cart', []);

        if (!isset($cart[$product->id])) {
            return redirect()->route('cart.index');
        }

        $cart[$product->id]['quantity'] = (int) $request->quantity;

        $request->session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart', []);

        unset($cart[$product->id]);

        $request->session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Product removed from cart.');
    }

    /**
     * Clear the entire cart.
     */
    public function clear(Request $request)
    {
        $request->session()->forget('cart');

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart cleared successfully.');
    }
}