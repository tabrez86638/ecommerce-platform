<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class StripePaymentController extends Controller
{
    public function createCheckoutSession(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        if ($order->payment_method !== 'stripe') {
            abort(403, 'This order is not a Stripe payment.');
        }

        if ($order->payment_status === 'paid') {
            return redirect()
                ->route('orders.confirmation', $order)
                ->with('success', 'This order has already been paid.');
        }

        if ($order->stripe_session_id) {
            $stripe = new StripeClient(
                config('services.stripe.secret')
            );

            $session = $stripe->checkout->sessions->retrieve(
                $order->stripe_session_id
            );

            if ($session->status === 'open' && $session->url) {
                return redirect()->away($session->url);
            }

            // if ($session->payment_status === 'paid') {
            //     $order->update([
            //         'payment_status' => 'paid',
            //         'status' => 'processing',
            //     ]);

            //     return redirect()
            //         ->route('orders.confirmation', $order)
            //         ->with('success', 'Payment confirmed successfully.');
            // }


            if ($session->payment_status === 'paid') {
            return redirect()
             ->route('stripe.success', [
            'session_id' => $session->id,
            ]);
            }
        }

        $lineItems = [];

        foreach ($order->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => strtolower($order->currency),
                    'product_data' => [
                        'name' => $item->product_name,
                    ],
                    'unit_amount' => (int) round(
                        (float) $item->unit_price * 100
                    ),
                ],
                'quantity' => $item->quantity,
            ];
        }

        $stripe = new StripeClient(
            config('services.stripe.secret')
        );

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            // 'payment_method_types' => ['card'],
            'customer_email' => $order->shipping_email,
            'client_reference_id' => (string) $order->id,
            'metadata' => [
                'order_id' => (string) $order->id,
                'user_id' => (string) $order->user_id,
            ],
            'line_items' => $lineItems,
            'success_url' => route('stripe.success', [], true)
                . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel', ['order' => $order->id], true),
        ]);

        $order->update([
            'stripe_session_id' => $session->id,
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        $request->validate([
            'session_id' => ['required', 'string'],
        ]);

        $sessionId = $request->query('session_id');

        $order = Order::where('stripe_session_id', $sessionId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $stripe = new StripeClient(
            config('services.stripe.secret')
        );

        $session = $stripe->checkout->sessions->retrieve($sessionId);

        if (
            $session->payment_status === 'paid'
            && (string) $session->client_reference_id === (string) $order->id
            && (int) $session->amount_total === (int) round(
                (float) $order->total_amount * 100
            )
            && strtolower($session->currency) === strtolower($order->currency)
        ) {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);

            session()->forget('cart');

            return redirect()
                ->route('orders.confirmation', $order)
                ->with('success', 'Payment confirmed successfully.');
        }

        return redirect()
            ->route('orders.confirmation', $order)
            ->with('error', 'Payment has not been confirmed yet.');
    }

    // public function cancel(Order $order)
    // {
    //     abort_unless($order->user_id === auth()->id(), 403);

    //     return redirect()
    //         ->route('checkout.index')
    //         ->with('error', 'Payment was cancelled. You can try again.');
    // }


//Address  will be visible after payment cancelled at checkout page 
    
public function cancel(Order $order)
{
    abort_unless($order->user_id === auth()->id(), 403);

    return redirect()
        ->route('checkout.index')
        ->with('error', 'Payment was cancelled. You can try again.')
        ->withInput([
            'first_name' => explode(' ', $order->shipping_name, 2)[0] ?? '',
            'last_name' => explode(' ', $order->shipping_name, 2)[1] ?? '',
            'email' => $order->shipping_email,
            'phone' => $order->shipping_phone,
            'shipping_address' => $order->shipping_address,
            'shipping_city' => $order->shipping_city,
            'shipping_state' => $order->shipping_state,
            'shipping_country' => $order->shipping_country,
            'shipping_postal_code' => $order->shipping_postal_code,
        ]);
}




    
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $signature,
                config('services.stripe.webhook_secret')
            );
        } catch (\UnexpectedValueException $e) {
    \Log::warning('Stripe webhook rejected: invalid payload');
    return response('Invalid payload', 400);
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    \Log::warning('Stripe webhook rejected: invalid signature');
    return response('Invalid signature', 400);
}

        if ($event->type === 'checkout.session.completed'
            || $event->type === 'checkout.session.async_payment_succeeded') {

            $session = $event->data->object;

            if ($session->payment_status !== 'paid') {
                return response('Payment not completed', 200);
            }

            $orderId = $session->metadata->order_id ?? null;

            if (!$orderId) {
            \Log::warning('Stripe webhook: missing order reference', [
            'event_id' => $event->id,
            'event_type' => $event->type,
            'session_id' => $session->id,
            ]);

            return response('Missing order reference', 400);
            }

            $order = Order::where('id', $orderId)
                ->where('stripe_session_id', $session->id)
                ->where('payment_method', 'stripe')
                ->first();

            if (!$order) {
                return response('Order not found', 404);
            }

            if (
                (string) $session->client_reference_id !== (string) $order->id
                || (int) $session->amount_total !== (int) round((float) $order->total_amount * 100)
                || strtolower($session->currency) !== strtolower($order->currency)
            ) {
                return response('Payment details do not match order', 400);
            }

            if ($order->payment_status !== 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing',
                ]);
            }
        }

        return response('Webhook received', 200);
    }

}
