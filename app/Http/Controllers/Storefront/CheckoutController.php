<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $productIds = array_keys($cart);

        $products = Product::whereIn('id', $productIds)
            ->where('status', 'published')
            ->get()
            ->keyBy('id');

        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            if (!isset($products[$productId])) {
                continue;
            }

            $price = $products[$productId]->sale_price
                ?? $products[$productId]->price;

            $subtotal += $price * $item['quantity'];
        }

        return view('storefront.checkout.index', [
            'cart' => $cart,
            'products' => $products,
            'subtotal' => $subtotal,
            'shipping' => 0,
            'tax' => 0,
            'discount' => 0,
            'total' => $subtotal,
        ]);
    }

    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],

            'shipping_address' => ['required', 'string', 'max:500'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'shipping_state' => ['nullable', 'string', 'max:100'],
            'shipping_country' => ['required', 'string', 'max:100'],
            'shipping_postal_code' => ['required', 'string', 'max:30'],

            'shipping_method' => ['required', 'string'],
            'payment_method' => ['required', 'in:cod,bank_transfer,stripe'],
        ]);

        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $productIds = array_keys($cart);

        $products = Product::whereIn('id', $productIds)
            ->where('status', 'published')
            ->get()
            ->keyBy('id');

        if ($products->count() !== count($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'One or more products in your cart are no longer available.');
        }

        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $price = $products[$productId]->sale_price
                ?? $products[$productId]->price;

            $subtotal += $price * $item['quantity'];
        }

        $shippingAmount = 0;
        $taxAmount = 0;
        $discountAmount = 0;
        $totalAmount = $subtotal + $shippingAmount + $taxAmount - $discountAmount;

        $order = DB::transaction(function () use (
            $validated,
            $cart,
            $products,
            $subtotal,
            $shippingAmount,
            $taxAmount,
            $discountAmount,
            $totalAmount
        ) {
            $order = Order::create([
                'user_id' => auth()->id(),

                'order_number' => 'ORD-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(5)),

                'status' => 'pending',

                'payment_status' => 'pending',

                'payment_method' => $validated['payment_method'],

                'currency' => 'USD',

                'subtotal' => $subtotal,

                'shipping_amount' => $shippingAmount,

                'tax_amount' => $taxAmount,

                'discount_amount' => $discountAmount,

                'total_amount' => $totalAmount,

                'shipping_name' =>
                    $validated['first_name'] . ' ' . $validated['last_name'],

                'shipping_email' => $validated['email'],

                'shipping_phone' => $validated['phone'],

                'shipping_address' => $validated['shipping_address'],

                'shipping_city' => $validated['shipping_city'],

                'shipping_state' => $validated['shipping_state'] ?? null,

                'shipping_country' => $validated['shipping_country'],

                'shipping_postal_code' => $validated['shipping_postal_code'],
            ]);

            foreach ($cart as $productId => $item) {

                $product = $products[$productId];

                $unitPrice = $product->sale_price
                    ?? $product->price;

                $lineTotal = $unitPrice * $item['quantity'];

                $order->items()->create([
                    'product_id' => $product->id,

                    'product_variant_id' => null,

                    'product_name' => $product->name,

                    'sku' => $product->sku,

                    'quantity' => $item['quantity'],

                    'unit_price' => $unitPrice,

                    'total_price' => $lineTotal,
                ]);
            }

            return $order;
        });

            if ($validated['payment_method'] === 'stripe') {
            return redirect()->route('stripe.checkout', [
            'order' => $order->id,
            ]);
        }

            $request->session()->forget('cart');

            return redirect()
            ->route('orders.confirmation', $order)
            ->with('success', 'Your order has been placed successfully.');
    }
}