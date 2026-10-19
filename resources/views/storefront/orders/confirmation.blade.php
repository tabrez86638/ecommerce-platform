@extends('layouts.storefront')

@section('title', 'Order Confirmation')

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">

        <div class="mb-3">
            <i class="bi bi-check-circle-fill text-success fs-1"></i>
        </div>

        <h1 class="fw-bold">
            Thank You for Your Order!
        </h1>

        <p class="text-secondary">
    @if($order->payment_status === 'paid')
        Your payment was successful and your order is confirmed.
    @elseif($order->payment_method === 'stripe')
        Your order has been created, but payment is still pending.
    @else
        Your order has been placed successfully.
    @endif
</p>

    </div>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4 p-md-5">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>
                            <small class="text-secondary">
                                Order Number
                            </small>

                            <h5 class="fw-bold mb-0">
                                {{ $order->order_number }}
                            </h5>
                        </div>

                        <span class="badge text-bg-warning">
                            {{ ucfirst($order->status) }}
                        </span>

                    </div>

                    <hr>

                    <h5 class="fw-bold mb-3">
                        Order Items
                    </h5>

                    @foreach($order->items as $item)

                        <div class="d-flex justify-content-between mb-3">

                            <div>
                                <strong>
                                    {{ $item->product_name }}
                                </strong>

                                <small class="d-block text-secondary">
                                    Qty: {{ $item->quantity }}
                                </small>
                            </div>

                            <span>
                                ${{ number_format($item->total_price, 2) }}
                            </span>

                        </div>

                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">
                            Subtotal
                        </span>

                        <span>
                            ${{ number_format($order->subtotal, 2) }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">
                            Shipping
                        </span>

                        <span>
                            ${{ number_format($order->shipping_amount, 2) }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-secondary">
                            Tax
                        </span>

                        <span>
                            ${{ number_format($order->tax_amount, 2) }}
                        </span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">

                        <strong>
                            Total
                        </strong>

                        <strong class="fs-4">
                            ${{ number_format($order->total_amount, 2) }}
                        </strong>

                    </div>

                    <div class="bg-light rounded-3 p-3 mb-4">

                        <h6 class="fw-bold">
                            Shipping Information
                        </h6>

                        <div>
                            {{ $order->shipping_name }}
                        </div>

                        <div>
                            {{ $order->shipping_address }}
                        </div>

                        <div>
                            {{ $order->shipping_city }}
                            @if($order->shipping_state)
                                , {{ $order->shipping_state }}
                            @endif
                        </div>

                        <div>
                            {{ $order->shipping_country }}
                            - {{ $order->shipping_postal_code }}
                        </div>

                        <div class="mt-2">
                            {{ $order->shipping_email }}
                        </div>

                        <div>
                            {{ $order->shipping_phone }}
                        </div>

                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-2">

                        <a
                            href="{{ route('home') }}"
                            class="btn btn-dark flex-fill"
                        >
                            Continue Shopping
                        </a>

                        <a
                            href="{{ route('account.index') }}"
                            class="btn btn-outline-dark flex-fill"
                        >
                            My Account
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection