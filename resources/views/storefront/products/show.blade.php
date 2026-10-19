@extends('layouts.storefront')

@section('title', $product->name . ' - Ecommerce')

@section('meta_description', $product->meta_description ?: $product->short_description)

@section('content')

    <!-- Breadcrumb -->
    <section class="py-3 bg-white border-bottom">
        <div class="container">

            <nav aria-label="breadcrumb">

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
                            href="{{ route('products.index') }}"
                            class="text-decoration-none text-secondary"
                        >
                            Products
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        {{ $product->name }}
                    </li>

                </ol>

            </nav>

        </div>
    </section>


    <!-- Product Details -->
    <section class="py-5">

        <div class="container">

            <div class="row g-5">

                <!-- Product Image -->
                <div class="col-lg-6">

                    <div class="bg-white rounded-4 shadow-sm overflow-hidden">

                        @php
                            $image = $product->images->first();
                        @endphp

                        @if($image)

                            <img
                                src="{{ asset('storage/' . $image->path) }}"
                                alt="{{ $image->alt_text ?: $product->name }}"
                                class="w-100"
                                style="height: 500px; object-fit: contain;"
                            >

                        @else

                            <div
                                class="d-flex align-items-center justify-content-center bg-light"
                                style="height: 500px;"
                            >
                                <i class="bi bi-image display-1 text-secondary"></i>
                            </div>

                        @endif

                    </div>

                </div>


                <!-- Product Information -->
                <div class="col-lg-6">

                    @if($product->brand)

                        <div class="text-secondary mb-2">
                            {{ $product->brand->name }}
                        </div>

                    @endif


                    <h1 class="display-5 fw-bold mb-3">
                        {{ $product->name }}
                    </h1>


                    @if($product->category)

                        <div class="mb-3">

                            <span class="badge bg-light text-dark border">
                                {{ $product->category->name }}
                            </span>

                        </div>

                    @endif


                    <!-- Price -->

                    <div class="mb-4">

                        @if($product->sale_price)

                            <span class="fs-2 fw-bold">
                                ${{ number_format($product->sale_price, 2) }}
                            </span>

                            <del class="fs-5 text-secondary ms-2">
                                ${{ number_format($product->price, 2) }}
                            </del>

                        @else

                            <span class="fs-2 fw-bold">
                                ${{ number_format($product->price, 2) }}
                            </span>

                        @endif

                    </div>


                    <!-- Short Description -->

                    @if($product->short_description)

                        <p class="text-secondary fs-5">
                            {{ $product->short_description }}
                        </p>

                    @endif


                    <hr class="my-4">


                    <!-- SKU -->

                    @if($product->sku)

                        <div class="mb-3">

                            <span class="text-secondary">
                                SKU:
                            </span>

                            <strong>
                                {{ $product->sku }}
                            </strong>

                        </div>

                    @endif


   
                    {{-- Quantity Selector --}}
                    <div class="mb-4">
                        <label for="quantity" class="form-label fw-semibold">
                            Quantity
                        </label>

                        <div class="input-group" style="max-width: 160px;">
                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                onclick="this.parentElement.querySelector('input').stepDown()"
                                aria-label="Decrease quantity"
                            >
                                <i class="bi bi-dash"></i>
                            </button>

                            <input
                                type="number"
                                name="quantity"
                                id="quantity"
                                form="cart-add-form"
                                class="form-control text-center"
                                value="{{ old('quantity', 1) }}"
                                min="1"
                                max="99"
                                step="1"
                                required
                            >

                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                onclick="this.parentElement.querySelector('input').stepUp()"
                                aria-label="Increase quantity"
                            >
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Actions: keep the cart and wishlist forms separate --}}
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <form
                            id="cart-add-form"
                            method="POST"
                            action="{{ route('cart.add', $product->id) }}"
                            class="flex-grow-1"
                        >
                            @csrf
                            <button
                                type="submit"
                                class="btn btn-dark btn-lg px-4 w-100"
                            >
                                <i class="bi bi-cart-plus me-2"></i>
                                Add to Cart
                            </button>
                        </form>

                        @if(auth()->check())
                            @php
                                $isWishlisted = auth()->user()
                                    ->wishlists()
                                    ->where('product_id', $product->id)
                                    ->exists();
                            @endphp

                            @if($isWishlisted)
                                <form
                                    method="POST"
                                    action="{{ route('wishlist.remove', $product) }}"
                                    class="flex-grow-1"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-outline-dark btn-lg w-100"
                                    >
                                        <i class="bi bi-heart-fill me-2"></i>
                                        In Wishlist
                                    </button>
                                </form>
                            @else
                                <form
                                    method="POST"
                                    action="{{ route('wishlist.add', $product) }}"
                                    class="flex-grow-1"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-outline-dark btn-lg w-100"
                                    >
                                        <i class="bi bi-heart me-2"></i>
                                        Add to Wishlist
                                    </button>
                                </form>
                            @endif
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="btn btn-outline-dark btn-lg flex-grow-1"
                            >
                                <i class="bi bi-heart me-2"></i>
                                Add to Wishlist
                            </a>
                        @endif
                    </div>

                    <!-- Product Description -->

                    @if($product->description)

                        <div class="mt-5">

                            <h4 class="fw-bold mb-3">
                                Description
                            </h4>

                            <div class="text-secondary">
                                {!! nl2br(e($product->description)) !!}
                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- Product Reviews --}}
<div class="container py-5">

    <div class="row g-4">

        {{-- Reviews --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h4 class="fw-bold mb-0">
                        Customer Reviews
                    </h4>
                </div>

                <div class="card-body">

                    @php
                        $approvedReviews = $product->reviews
                            ->where('status', 'approved');

                        $reviewCount = $approvedReviews->count();

                        $averageRating = $reviewCount > 0
                            ? round($approvedReviews->avg('rating'), 1)
                            : 0;
                    @endphp

                    {{-- Rating Summary --}}
                    <div class="d-flex align-items-center gap-3 mb-4">

                        <div class="display-6 fw-bold">
                            {{ number_format($averageRating, 1) }}
                        </div>

                        <div>

                            <div class="text-warning fs-5">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($averageRating))
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                            </div>

                            <small class="text-muted">
                                {{ $reviewCount }}
                                {{ $reviewCount === 1 ? 'review' : 'reviews' }}
                            </small>

                        </div>

                    </div>

                    @if($approvedReviews->count())

                        @foreach($approvedReviews as $review)

                            <div class="border-top py-4">

                                <div class="d-flex justify-content-between">

                                    <div>
                                        <strong>
                                            {{ $review->title }}
                                        </strong>

                                        <div class="text-warning mt-1">

                                            @for($i = 1; $i <= 5; $i++)

                                                @if($i <= $review->rating)
                                                    <i class="bi bi-star-fill"></i>
                                                @else
                                                    <i class="bi bi-star"></i>
                                                @endif

                                            @endfor

                                        </div>
                                    </div>

                                    <small class="text-muted">
                                        {{ $review->created_at->format('d M Y') }}
                                    </small>

                                </div>

                                <p class="mt-3 mb-2">
                                    {{ $review->comment }}
                                </p>

                                <small class="text-muted">
                                    <i class="bi bi-person me-1"></i>
                                    {{ $review->user->name ?? 'Customer' }}
                                </small>

                            </div>

                        @endforeach

                    @else

                        <div class="text-center py-4">

                            <i class="bi bi-chat-square-text display-5 text-muted"></i>

                            <h5 class="mt-3">
                                No reviews yet
                            </h5>

                            <p class="text-muted mb-0">
                                Be the first customer to review this product.
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- Review Form --}}
<div class="col-lg-4">

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <h5 class="fw-bold mb-3">
                Write a Review
            </h5>

            @auth

                @php
                    $purchasedOrders = auth()->user()
                        ->orders()
                        ->whereHas('items', function ($query) use ($product) {
                            $query->where('product_id', $product->id);
                        })
                        ->with('items')
                        ->latest()
                        ->get();
                @endphp

                @if($purchasedOrders->count())

                    <p class="text-muted small">
                        You purchased this product. Share your experience
                        with other customers.
                    </p>

                    @if($errors->has('review'))
                        <div class="alert alert-danger">
                            {{ $errors->first('review') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('reviews.store', $product) }}">

                        @csrf

                        {{-- Order --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Order
                            </label>

                            <select name="order_id"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Select your order
                                </option>

                                @foreach($purchasedOrders as $order)

                                    <option value="{{ $order->id }}">
                                        {{ $order->order_number }}
                                        -
                                        {{ $order->created_at->format('d M Y') }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Rating --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Rating
                            </label>

                            <select name="rating"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Select rating
                                </option>

                                <option value="5">★★★★★ - Excellent</option>
                                <option value="4">★★★★☆ - Very Good</option>
                                <option value="3">★★★☆☆ - Good</option>
                                <option value="2">★★☆☆☆ - Fair</option>
                                <option value="1">★☆☆☆☆ - Poor</option>

                            </select>

                        </div>

                        {{-- Title --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Review Title
                            </label>

                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   maxlength="255"
                                   placeholder="Summarize your experience"
                                   value="{{ old('title') }}"
                                   required>

                        </div>

                        {{-- Comment --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Your Review
                            </label>

                            <textarea name="comment"
                                      class="form-control"
                                      rows="5"
                                      maxlength="2000"
                                      placeholder="Tell us about your experience..."
                                      required>{{ old('comment') }}</textarea>

                        </div>

                        <button type="submit"
                                class="btn btn-dark w-100">

                            <i class="bi bi-star me-2"></i>
                            Submit Review

                        </button>

                    </form>

                @else

                    <div class="alert alert-light border mb-0">

                        <i class="bi bi-info-circle me-2"></i>

                        You can review this product after purchasing it.

                    </div>

                @endif

            @else

                <p class="text-muted">
                    Please login to write a review.
                </p>

                <a href="{{ route('login') }}"
                   class="btn btn-dark w-100">

                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Login to Review

                </a>

            @endauth

        </div>

    </div>

</div>

</div>

        </div>

    </section>

@endsection