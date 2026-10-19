@extends('layouts.storefront')

@section('title', 'My Wishlist')

@section('content')

<div class="container py-5">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">My Wishlist</h1>
            <p class="text-muted mb-0">
                Save your favorite products for later.
            </p>
        </div>

        <a href="{{ route('home') }}" class="btn btn-outline-dark mt-3 mt-md-0">
            <i class="bi bi-arrow-left me-2"></i>
            Continue Shopping
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($wishlists->count())

        <div class="row g-4">

            @foreach($wishlists as $wishlist)

                @php
                    $product = $wishlist->product;

                    if (!$product) {
                    continue;
                    }

                    $image = $product->images->firstWhere('is_primary', true)
                    ?? $product->images->first();

                    $price = $product->sale_price !== null
                    && (float) $product->sale_price > 0
                    ? $product->sale_price
                    : $product->price;
                @endphp

                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                    <div class="card h-100 border-0 shadow-sm">

                        <div class="position-relative">

                            @if($image)
                                <img
                                    src="{{ asset('storage/' . $image->path) }}"
                                    class="card-img-top"
                                    alt="{{ $image->alt_text ?? $product->name }}"
                                    style="height: 240px; object-fit: cover;"
                                >
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                     style="height: 240px;">
                                    <i class="bi bi-image fs-1 text-muted"></i>
                                </div>
                            @endif

                        </div>

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title mb-2">
                                {{ $product->name }}
                            </h5>

                            <div class="mb-3">

                                @if($product->sale_price)
                                    <span class="fw-bold fs-5">
                                        ${{ number_format($product->sale_price, 2) }}
                                    </span>

                                    <span class="text-muted text-decoration-line-through ms-2">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                @else
                                    <span class="fw-bold fs-5">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                @endif

                            </div>

                            <div class="mt-auto d-flex gap-2">

                                <a href="{{ route('products.show', $product->slug) }}"
                                   class="btn btn-dark flex-grow-1">
                                    View Product
                                </a>

                                <form method="POST"
                                      action="{{ route('wishlist.remove', $product) }}">
                                    @csrf

                                    <button type="submit"
                                            class="btn btn-outline-danger"
                                            title="Remove from wishlist">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-4">
            {{ $wishlists->links() }}
        </div>

    @else

        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">

                <div class="mb-3">
                    <i class="bi bi-heart display-4 text-muted"></i>
                </div>

                <h4 class="fw-bold">Your wishlist is empty</h4>

                <p class="text-muted mb-4">
                    Save products you love and come back to them later.
                </p>

                <a href="{{ route('products.index') }}" class="btn btn-dark">
                    Browse Products
                </a>

            </div>
        </div>

    @endif

</div>

@endsection