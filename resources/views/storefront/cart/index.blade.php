@extends('layouts.storefront')

@section('title', 'Shopping Cart')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Shopping Cart</h2>
            <p class="text-muted mb-0">
                Review your items before checkout.
            </p>
        </div>

        @if(count($cart) > 0)
            <form method="POST" action="{{ route('cart.clear') }}">
                @csrf

                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i>
                    Clear Cart
                </button>
            </form>
        @endif
    </div>

    @if(count($cart) === 0)

        {{-- Empty Cart --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">

                <i class="bi bi-cart-x fs-1 text-muted"></i>

                <h4 class="fw-bold mt-3">
                    Your cart is empty
                </h4>

                <p class="text-muted">
                    Looks like you haven't added anything to your cart yet.
                </p>

                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-dark"
                >
                    Continue Shopping
                </a>

            </div>
        </div>

    @else

        <div class="row g-4">

            {{-- Cart Items --}}
            <div class="col-lg-8">

                @foreach($cart as $productId => $item)

                    @php
                        $product = $products[$productId] ?? null;
                    @endphp

                    @if($product)

                        @php
                            $price = $product->sale_price ?? $product->price;
                            $lineTotal = $price * $item['quantity'];

                            $image = $product->images->first();
                        @endphp

                        <div class="card border-0 shadow-sm mb-3">

                            <div class="card-body">

                                <div class="row align-items-center g-3">

                                    {{-- Product Image --}}
                                    <div class="col-4 col-md-2">

                                        @if($image)

                                            <img
                                                src="{{ asset('storage/' . $image->path) }}"
                                                alt="{{ $product->name }}"
                                                class="img-fluid rounded"
                                                style="height: 90px; width: 90px; object-fit: cover;"
                                            >

                                        @else

                                            <div
                                                class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="height: 90px; width: 90px;"
                                            >
                                                <i class="bi bi-image text-muted fs-3"></i>
                                            </div>

                                        @endif

                                    </div>

                                    {{-- Product Details --}}
                                    <div class="col-8 col-md-4">

                                        <h5 class="fw-semibold mb-1">
                                            {{ $product->name }}
                                        </h5>

                                        @if($product->sku)
                                            <small class="text-muted">
                                                SKU: {{ $product->sku }}
                                            </small>
                                        @endif

                                        <div class="mt-2">

                                            @if($product->sale_price)
                                                <span class="fw-bold">
                                                    {{ number_format($product->sale_price, 2) }}
                                                </span>

                                                <span class="text-muted text-decoration-line-through ms-2">
                                                    {{ number_format($product->price, 2) }}
                                                </span>
                                            @else
                                                <span class="fw-bold">
                                                    {{ number_format($product->price, 2) }}
                                                </span>
                                            @endif

                                        </div>

                                    </div>


{{-- Quantity --}}
<div class="col-6 col-md-3">
    <form
        method="POST"
        action="{{ route('cart.update', $product->id) }}"
        class="cart-quantity-form"
    >
        @csrf

        <label class="form-label small text-muted">
            Quantity
        </label>

        <div class="input-group">
            <input
                type="number"
                name="quantity"
                value="{{ $item['quantity'] }}"
                min="1"
                max="99"
                step="1"
                class="form-control cart-quantity-input"
                required
            >

            <button
                type="submit"
                class="btn btn-outline-dark cart-update-button"
                title="Update quantity"
            >
                <i class="bi bi-arrow-repeat"></i>
            </button>
        </div>
    </form>

</div>


                                    {{-- Total / Remove --}}
                                    <div class="col-6 col-md-3 text-md-end">

                                        <div class="fw-bold mb-2">
                                            {{ number_format($lineTotal, 2) }}
                                        </div>

                                        <form
                                            method="POST"
                                            action="{{ route('cart.remove', $product->id) }}"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                <i class="bi bi-trash me-1"></i>
                                                Remove
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif

                @endforeach

            </div>

            {{-- Cart Summary --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Order Summary
                        </h5>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">
                                Subtotal
                            </span>

                            <span class="fw-semibold">
                                {{ number_format($subtotal, 2) }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">
                                Shipping
                            </span>

                            <span class="fw-semibold">
                                Free
                            </span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">

                            <span class="fw-bold">
                                Total
                            </span>

                            <span class="fw-bold fs-5">
                                {{ number_format($total, 2) }}
                            </span>

                        </div>

                        <a
                            href="{{ route('checkout.index') }}"
                            class="btn btn-dark w-100 py-2"
                        >
                            Proceed to Checkout
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>

                        <a
                            href="{{ route('products.index') }}"
                            class="btn btn-outline-secondary w-100 mt-2"
                        >
                            Continue Shopping
                        </a>

                    </div>

                </div>

            </div>

        </div>

    @endif

</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cart-quantity-form').forEach(function (form) {
        const input = form.querySelector('.cart-quantity-input');
        let timer;

        input.addEventListener('input', function () {
            clearTimeout(timer);

            timer = setTimeout(function () {
                const quantity = Number(input.value);

                if (
                    input.value.trim() !== '' &&
                    Number.isInteger(quantity) &&
                    quantity >= 1 &&
                    quantity <= 99
                ) {
                    form.requestSubmit();
                }
            }, 700);
        });
    });
});
</script>
