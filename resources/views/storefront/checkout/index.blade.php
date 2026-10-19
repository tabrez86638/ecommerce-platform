@extends('layouts.storefront')

@section('title', 'Checkout - Ecommerce')

@section('meta_description', 'Complete your order securely.')

@section('content')

<!-- Page Header -->
<section class="py-5 bg-white border-bottom">
    <div class="container">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">

                <li class="breadcrumb-item">
                    <a
                        href="{{ route('home') }}"
                        class="text-decoration-none text-secondary"
                    >
                        Home
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a
                        href="{{ route('cart.index') }}"
                        class="text-decoration-none text-secondary"
                    >
                        Cart
                    </a>
                </li>

                <li class="breadcrumb-item active">
                    Checkout
                </li>

            </ol>
        </nav>

        <h1 class="fw-bold mb-2">
            Checkout
        </h1>

        <p class="text-secondary mb-0">
            Complete your details to place your order.
        </p>

    </div>
</section>


<!-- Checkout -->
<section class="py-5">

    <div class="container">

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <strong>Please correct the following:</strong>

                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('checkout.place-order') }}"
        >

            @csrf

            <div class="row g-4">

                <!-- Customer Details -->
                <div class="col-lg-8">

                    <!-- Contact Information -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">

                        <div class="card-body p-4">

                            <h5 class="fw-bold mb-4">
                                Contact Information
                            </h5>

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label class="form-label">
                                        First Name
                                    </label>

                                    <input
                                        type="text"
                                        name="first_name"
                                        class="form-control"
                                        value="{{ old('first_name', explode(' ', auth()->user()->name)[0] ?? '') }}"
                                        placeholder="First name"
                                        required
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Last Name
                                    </label>

                                    <input
                                        type="text"
                                        name="last_name"
                                        class="form-control"
                                        value="{{ old('last_name', count(explode(' ', auth()->user()->name)) > 1 ? implode(' ', array_slice(explode(' ', auth()->user()->name), 1)) : '') }}"
                                        placeholder="Last name"
                                        required
                                    >

                                </div>


                                <div class="col-12">

                                    <label class="form-label">
                                        Email Address
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        value="{{ old('email', auth()->user()->email) }}"
                                        placeholder="you@example.com"
                                        required
                                    >

                                </div>


                                <div class="col-12">

                                    <label class="form-label">
                                        Phone Number
                                    </label>

                                    <input
                                        type="tel"
                                        name="phone"
                                        class="form-control"
                                        value="{{ old('phone') }}"
                                        placeholder="+971 XX XXX XXXX"
                                        required
                                    >

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- Shipping Address -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">

                        <div class="card-body p-4">

                            <h5 class="fw-bold mb-4">
                                Shipping Address
                            </h5>

                            <div class="row g-3">

                                <div class="col-12">

                                    <label class="form-label">
                                        Address
                                    </label>

                                    <input
                                        type="text"
                                        name="shipping_address"
                                        class="form-control"
                                        value="{{ old('shipping_address') }}"
                                        placeholder="Street address"
                                        required
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        City
                                    </label>

                                    <input
                                        type="text"
                                        name="shipping_city"
                                        class="form-control"
                                        value="{{ old('shipping_city') }}"
                                        placeholder="City"
                                        required
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        State / Province
                                    </label>

                                    <input
                                        type="text"
                                        name="shipping_state"
                                        class="form-control"
                                        value="{{ old('shipping_state') }}"
                                        placeholder="State / Province"
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Country
                                    </label>

                                    <select
                                        class="form-select"
                                        name="shipping_country"
                                        required
                                    >

                                        <option value="">
                                            Select Country
                                        </option>

                                        <option
                                            value="United Arab Emirates"
                                            {{ old('shipping_country') === 'United Arab Emirates' ? 'selected' : '' }}
                                        >
                                            United Arab Emirates
                                        </option>

                                        <option
                                            value="India"
                                            {{ old('shipping_country') === 'India' ? 'selected' : '' }}
                                        >
                                            India
                                        </option>

                                        <option
                                            value="Saudi Arabia"
                                            {{ old('shipping_country') === 'Saudi Arabia' ? 'selected' : '' }}
                                        >
                                            Saudi Arabia
                                        </option>

                                    </select>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Postal Code
                                    </label>

                                    <input
                                        type="text"
                                        name="shipping_postal_code"
                                        class="form-control"
                                        value="{{ old('shipping_postal_code') }}"
                                        placeholder="Postal code"
                                        required
                                    >

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- Shipping Method -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">

                        <div class="card-body p-4">

                            <h5 class="fw-bold mb-4">
                                Shipping Method
                            </h5>

                            <div class="border rounded-3 p-3">

                                <div class="form-check">

                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="shipping_method"
                                        id="standard_shipping"
                                        value="standard"
                                        checked
                                        required
                                    >

                                    <label
                                        class="form-check-label w-100"
                                        for="standard_shipping"
                                    >

                                        <div class="d-flex justify-content-between">

                                            <span>

                                                <strong>
                                                    Standard Shipping
                                                </strong>

                                                <small class="d-block text-secondary">
                                                    Delivery within 3–5 business days
                                                </small>

                                            </span>

                                            <strong>
                                                Free
                                            </strong>

                                        </div>

                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- Payment Method -->
                    <div class="card border-0 shadow-sm rounded-4">

                        <div class="card-body p-4">

                            <h5 class="fw-bold mb-4">
                                Payment Method
                            </h5>


                            <div class="border rounded-3 p-3 mb-3">

                                <div class="form-check">

                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="payment_method"
                                        id="cash_on_delivery"
                                        value="cod"
                                        checked
                                        required
                                    >

                                    <label
                                        class="form-check-label"
                                        for="cash_on_delivery"
                                    >

                                        <strong>
                                            Cash on Delivery
                                        </strong>

                                        <small class="d-block text-secondary">
                                            Pay when your order is delivered.
                                        </small>

                                    </label>

                                </div>

                            </div>


                            <div class="border rounded-3 p-3">

                                <div class="form-check">

                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="payment_method"
                                        id="bank_transfer"
                                        value="bank_transfer"
                                    >

                                    <label
                                        class="form-check-label"
                                        for="bank_transfer"
                                    >

                                        <strong>
                                            Bank Transfer
                                        </strong>

                                        <small class="d-block text-secondary">
                                            Pay using a bank transfer.
                                        </small>

                                    </label>

                                </div>

                                
<div class="border rounded-3 p-3 mt-3">

    <div class="form-check">

        <input
            class="form-check-input"
            type="radio"
            name="payment_method"
            id="stripe"
            value="stripe"
        >

        <label
            class="form-check-label"
            for="stripe"
        >

            <strong>
                Pay Online with Stripe
            </strong>

            <small class="d-block text-secondary">
                Pay securely using your card through Stripe Checkout.
                Test mode is currently enabled.
            </small>

        </label>

    </div>

</div>


                            </div>

                        </div>

                    </div>

                </div>


                <!-- Order Summary -->
                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm rounded-4">

                        <div class="card-body p-4">

                            <h5 class="fw-bold mb-4">
                                Order Summary
                            </h5>


                            @foreach($cart as $productId => $item)

                                @php
                                    $product = $products[$productId] ?? null;
                                @endphp

                                @if($product)

                                    @php
                                        $price = $product->sale_price ?? $product->price;
                                        $lineTotal = $price * $item['quantity'];
                                    @endphp

                                    <div class="d-flex justify-content-between mb-3">

                                        <div>

                                            <strong>
                                                {{ $product->name }}
                                            </strong>

                                            <small class="d-block text-secondary">
                                                Qty: {{ $item['quantity'] }}
                                            </small>

                                        </div>

                                        <span>
                                            ${{ number_format($lineTotal, 2) }}
                                        </span>

                                    </div>

                                @endif

                            @endforeach


                            <hr>


                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-secondary">
                                    Subtotal
                                </span>

                                <span>
                                    ${{ number_format($subtotal, 2) }}
                                </span>

                            </div>


                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-secondary">
                                    Shipping
                                </span>

                                <span>
                                    Free
                                </span>

                            </div>


                            <hr>


                            <div class="d-flex justify-content-between mb-4">

                                <strong>
                                    Total
                                </strong>

                                <strong class="fs-5">
                                    ${{ number_format($total, 2) }}
                                </strong>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-dark btn-lg w-100"
                            >
                                <i class="bi bi-lock me-2"></i>
                                Place Order
                            </button>


                            <p class="text-center text-secondary small mt-3 mb-0">
                                Your information is securely handled.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</section>

@endsection