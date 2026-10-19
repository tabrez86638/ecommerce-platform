@extends('layouts.storefront')

@section('title', 'Order ' . $order->order_number)

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Order Details</h1>
            <p class="text-muted mb-0">
                Order #{{ $order->order_number }}
            </p>
        </div>

        <a href="{{ route('account.orders') }}"
           class="btn btn-outline-dark mt-3 mt-md-0">
            <i class="bi bi-arrow-left me-2"></i>
            Back to My Orders
        </a>
    </div>

    {{-- Order Status --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-3">
                    <small class="text-muted d-block mb-1">Order Date</small>
                    <strong>
                        {{ $order->created_at->format('d M Y, h:i A') }}
                    </strong>
                </div>

                <div class="col-md-3">
                    <small class="text-muted d-block mb-1">Order Status</small>

                    @php
                        $statusClass = match($order->status) {
                            'completed' => 'success',
                            'processing' => 'primary',
                            'shipped' => 'info',
                            'cancelled' => 'danger',
                            default => 'warning',
                        };
                    @endphp

                    <span class="badge text-bg-{{ $statusClass }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="col-md-3">
                    <small class="text-muted d-block mb-1">Payment Status</small>

                    <span class="text-capitalize">
                        {{ str_replace('_', ' ', $order->payment_status) }}
                    </span>
                </div>

                <div class="col-md-3">
                    <small class="text-muted d-block mb-1">Payment Method</small>

                    <span class="text-capitalize">
                        {{ str_replace('_', ' ', $order->payment_method ?? 'N/A') }}
                    </span>
                </div>

            </div>

        </div>
    </div>

    <div class="row g-4">

        {{-- Products --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        Ordered Items
                    </h5>
                </div>

                <div class="card-body">

                    @foreach($order->items as $item)

                        <div class="d-flex justify-content-between align-items-start
                                    py-3 {{ !$loop->last ? 'border-bottom' : '' }}">

                            <div>
                                <h6 class="mb-1 fw-semibold">
                                    {{ $item->product_name }}
                                </h6>

                                @if($item->sku)
                                    <small class="text-muted d-block">
                                        SKU: {{ $item->sku }}
                                    </small>
                                @endif

                                <small class="text-muted">
                                    Quantity: {{ $item->quantity }}
                                    × ${{ number_format($item->unit_price, 2) }}
                                </small>
                            </div>

                            <div class="fw-semibold">
                                ${{ number_format($item->total_price, 2) }}
                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

        {{-- Order Summary --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        Order Summary
                    </h5>
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span>
                            ${{ number_format($order->subtotal, 2) }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span>
                            ${{ number_format($order->shipping_amount, 2) }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tax</span>
                        <span>
                            ${{ number_format($order->tax_amount, 2) }}
                        </span>
                    </div>

                    @if($order->discount_amount > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Discount</span>
                            <span class="text-success">
                                -${{ number_format($order->discount_amount, 2) }}
                            </span>
                        </div>
                    @endif

                    <hr>

                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong class="fs-5">
                            ${{ number_format($order->total_amount, 2) }}
                        </strong>
                    </div>

                </div>

            </div>

            {{-- Shipping Information --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        Shipping Information
                    </h5>
                </div>

                <div class="card-body">

                    <p class="fw-semibold mb-1">
                        {{ $order->shipping_name }}
                    </p>

                    <p class="text-muted mb-1">
                        {{ $order->shipping_address }}
                    </p>

                    <p class="text-muted mb-1">
                        {{ $order->shipping_city }}

                        @if($order->shipping_state)
                            , {{ $order->shipping_state }}
                        @endif

                        {{ $order->shipping_postal_code }}
                    </p>

                    <p class="text-muted mb-3">
                        {{ $order->shipping_country }}
                    </p>

                    <hr>

                    <p class="mb-1">
                        <i class="bi bi-envelope me-2"></i>
                        {{ $order->shipping_email }}
                    </p>

                    <p class="mb-0">
                        <i class="bi bi-telephone me-2"></i>
                        {{ $order->shipping_phone }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection