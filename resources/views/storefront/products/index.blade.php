@extends('layouts.storefront')

@section('title', 'Products - Ecommerce')

@section('meta_description', 'Browse our latest products.')

@section('content')

<!-- Page Header -->
<section class="py-4 py-md-5 bg-white border-bottom">
    <div class="container">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}"
                       class="text-decoration-none text-secondary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h1 class="fw-bold mb-2">All Products</h1>
                <p class="text-secondary mb-0">
                    Discover our latest products.
                </p>
            </div>

            <div class="text-secondary">
                {{ $products->total() }} products
            </div>
        </div>

    </div>
</section>


{{-- Product Filters --}}
<section class="py-4 bg-light border-bottom">
    <div class="container">

        <form action="{{ route('products.index') }}" method="GET">

            {{-- Preserve Navbar Search --}}
            @if(request('search'))
                <input
                    type="hidden"
                    name="search"
                    value="{{ request('search') }}"
                >
            @endif

            <div class="row g-3 align-items-end">

                {{-- Category --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <label for="category" class="form-label fw-semibold">
                        Category
                    </label>

                    <select name="category" id="category" class="form-select">
                        <option value="">All Categories</option>

                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected((string) $categoryId === (string) $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Brand --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <label for="brand" class="form-label fw-semibold">
                        Brand
                    </label>

                    <select name="brand" id="brand" class="form-select">
                        <option value="">All Brands</option>

                        @foreach($brands as $brand)
                            <option
                                value="{{ $brand->id }}"
                                @selected((string) $brandId === (string) $brand->id)
                            >
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Minimum Price --}}
                <div class="col-6 col-sm-6 col-lg-2">
                    <label for="min_price" class="form-label fw-semibold">
                        Min Price
                    </label>

                    <input
                        type="number"
                        name="min_price"
                        id="min_price"
                        class="form-control"
                        placeholder="0.00"
                        min="0"
                        step="0.01"
                        value="{{ $minPrice ?? '' }}"
                    >
                </div>

                {{-- Maximum Price --}}
                <div class="col-6 col-sm-6 col-lg-2">
                    <label for="max_price" class="form-label fw-semibold">
                        Max Price
                    </label>

                    <input
                        type="number"
                        name="max_price"
                        id="max_price"
                        class="form-control"
                        placeholder="No limit"
                        min="0"
                        step="0.01"
                        value="{{ $maxPrice ?? '' }}"
                    >
                </div>

                {{-- Sorting --}}
                <div class="col-12 col-sm-6 col-lg-2">
                    <label for="sort" class="form-label fw-semibold">
                        Sort By
                    </label>

                    <select name="sort" id="sort" class="form-select">
                        <option value="newest"
                            @selected(($sort ?? 'newest') === 'newest')>
                            Newest First
                        </option>

                        <option value="price_low"
                            @selected(($sort ?? 'newest') === 'price_low')>
                            Price: Low to High
                        </option>

                        <option value="price_high"
                            @selected(($sort ?? 'newest') === 'price_high')>
                            Price: High to Low
                        </option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <button type="submit" class="btn btn-dark w-100">
                        <i class="bi bi-funnel me-1" aria-hidden="true"></i>
                        Apply Filters
                    </button>
                </div>

                <div class="col-6 col-md-3 col-lg-2">
                    <a
                        href="{{ route('products.index', request('search') ? ['search' => request('search')] : []) }}"
                        class="btn btn-outline-secondary w-100"
                    >
                        Clear Filters
                    </a>
                </div>

            </div>
        </form>
    </div>
</section>



<!-- Products -->
<section class="py-4 py-md-5">
    <div class="container">

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">

            @forelse($products as $product)

                @php
                    $image = $product->images->firstWhere('is_primary', true)
                        ?? $product->images->first();

                    $displayPrice = $product->sale_price !== null
                        && (float) $product->sale_price > 0
                        ? $product->sale_price
                        : $product->price;
                @endphp

                <div class="col">
                    <div class="card product-card h-100 border-0 shadow-sm overflow-hidden">

                        <a href="{{ route('products.show', $product->slug) }}"
                           class="text-decoration-none text-dark">

                            <!-- Product Image -->
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                 style="height:220px; overflow:hidden;">

                                @if($image)
                                    <img
                                        src="{{ asset('storage/' . $image->path) }}"
                                        alt="{{ $image->alt_text ?: $product->name }}"
                                        loading="lazy"
                                        style="width:100%;height:100%;object-fit:contain;"
                                    >
                                @else
                                    <i class="bi bi-image display-4 text-secondary"></i>
                                @endif

                            </div>

                            <!-- Product Details -->
                            <div class="card-body d-flex flex-column">

                                <small class="text-secondary">
                                    {{ $product->category?->name ?? 'Product' }}
                                </small>

                                <h6 class="fw-semibold mt-2 mb-2">
                                    {{ $product->name }}
                                </h6>

                                @if($product->brand)
                                    <small class="text-secondary">
                                        {{ $product->brand->name }}
                                    </small>
                                @endif

                                <div class="mt-3">
                                    <span class="fw-bold">
                                        ${{ number_format((float) $displayPrice, 2) }}
                                    </span>

                                    @if(
                                        $product->sale_price !== null
                                        && (float) $product->sale_price > 0
                                        && (float) $product->sale_price < (float) $product->price
                                    )
                                        <del class="text-secondary ms-2 small">
                                            ${{ number_format((float) $product->price, 2) }}
                                        </del>
                                    @endif
                                </div>

                            </div>
                        </a>

                        <div class="card-footer bg-white border-0 pt-0">
                            <a href="{{ route('products.show', $product->slug) }}"
                               class="btn btn-outline-dark btn-sm w-100">
                                View Product
                            </a>
                        </div>

                    </div>
                </div>

            @empty

                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-box-seam display-3 text-secondary"></i>
                        <h4 class="mt-3">No products found</h4>
                        <p class="text-secondary">
                            Products will appear here once they are available.
                        </p>
                    </div>
                </div>

            @endforelse

        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links() }}
            </div>
        @endif

    </div>
</section>

@endsection