
@extends('layouts.storefront')

@section('title', $category->name . ' - Ecommerce')

@section('meta_description', 'Browse products in ' . $category->name . '.')

@section('content')
<section class="py-4 py-lg-5 bg-light">
    <div class="container">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('categories.index') }}" class="text-decoration-none">Categories</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $category->name }}
                </li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="row g-0 align-items-center">
                @if($category->image)
                    <div class="col-md-4">
                        <img
                            src="{{ asset('storage/' . $category->image) }}"
                            alt="{{ $category->name }}"
                            class="w-100"
                            style="height: 220px; object-fit: cover;"
                        >
                    </div>
                @endif

                <div class="{{ $category->image ? 'col-md-8' : 'col-12' }}">
                    <div class="p-4 p-lg-5">
                        <span class="text-secondary small text-uppercase fw-semibold">
                            Explore our collection
                        </span>
                        <h1 class="fw-bold mt-2">{{ $category->name }}</h1>

                        @if($category->description)
                            <p class="text-secondary mb-0">
                                {{ $category->description }}
                            </p>
                        @else
                            <p class="text-secondary mb-0">
                                Discover products from our {{ $category->name }} collection.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 fw-bold mb-0">Products</h2>
            <span class="text-secondary small">
                {{ $products->total() }} products
            </span>
        </div>

        <div class="row g-3 g-lg-4">
            @forelse($products as $product)
                @php
                    $primaryImage = $product->images->firstWhere('is_primary', true)
                        ?? $product->images->first();

                    $displayPrice = $product->sale_price !== null
                        && (float) $product->sale_price > 0
                        ? $product->sale_price
                        : $product->price;
                @endphp

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <a href="{{ route('products.show', $product->slug) }}"
                           class="text-decoration-none text-dark">
                            <div class="bg-light d-flex justify-content-center align-items-center"
                                 style="height: 210px; overflow: hidden;">
                                @if($primaryImage)
                                    <img
                                        src="{{ asset('storage/' . $primaryImage->path) }}"
                                        alt="{{ $primaryImage->alt_text ?: $product->name }}"
                                        class="w-100 h-100"
                                        style="object-fit: contain;"
                                    >
                                @else
                                    <i class="bi bi-image display-4 text-secondary"></i>
                                @endif
                            </div>

                            <div class="card-body">
                                <small class="text-secondary">
                                    {{ $product->brand?->name ?? $category->name }}
                                </small>
                                <h5 class="fw-semibold mt-1 mb-2">
                                    {{ $product->name }}
                                </h5>

                                <span class="fw-bold">
                                    ${{ number_format((float) $displayPrice, 2) }}
                                </span>

                                @if($product->sale_price !== null
                                    && (float) $product->sale_price > 0
                                    && (float) $product->sale_price < (float) $product->price)
                                    <del class="small text-secondary ms-1">
                                        ${{ number_format((float) $product->price, 2) }}
                                    </del>
                                @endif
                            </div>
                        </a>

                        <div class="card-footer bg-white border-0 pt-0">
                            <a href="{{ route('products.show', $product->slug) }}"
                               class="btn btn-dark w-100">
                                View Product
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center bg-white rounded-4 p-5">
                        <i class="bi bi-box-seam display-4 text-secondary"></i>
                        <h4 class="mt-3">No products available yet</h4>
                        <p class="text-secondary">
                            We're adding products to this collection. Please check back soon.
                        </p>
                        <a href="{{ route('products.index') }}" class="btn btn-dark">
                            Browse All Products
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>

    </div>
</section>
@endsection
