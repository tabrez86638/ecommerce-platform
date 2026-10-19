@extends('layouts.storefront')

@section('title', 'Home - Ecommerce')

@section('meta_description', 'Discover quality products at great prices.')

@section('content')

<!-- Hero Section -->  
<!-- Hero Slider -->
<section class="py-4 py-lg-5 bg-white">
    <div class="container">
        <div id="homeHeroSlider"
             class="carousel slide carousel-fade"
             data-bs-ride="carousel"
             data-bs-interval="5000">

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#homeHeroSlider"
                        data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#homeHeroSlider"
                        data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#homeHeroSlider"
                        data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner rounded-4 overflow-hidden shadow-sm">

                <!-- Slide 1: Fashion -->
                <div class="carousel-item active">
                    <div class="row align-items-center g-0"
                         style="min-height: 390px; background: #f4f0ec;">
                        <div class="col-lg-6 p-4 p-md-5">
                            <span class="badge bg-dark mb-3">Discover Your Style</span>
                            <h1 class="display-5 fw-bold mb-3">
                                Everyday style.<br>Extraordinary you.
                            </h1>
                            <p class="lead text-secondary mb-4">
                                Explore fashion and accessories for every occasion.
                            </p>
                            <a href="{{ route('products.index') }}"
                               class="btn btn-dark btn-lg px-4">
                                Shop Fashion <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <img
                                src="https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1200&q=85"
                                class="d-block w-100"
                                alt="Fashion shopping collection"
                                style="height: 390px; object-fit: cover;">
                        </div>
                    </div>
                </div>

                <!-- Slide 2: Electronics -->
                <div class="carousel-item">
                    <div class="row align-items-center g-0"
                         style="min-height: 390px; background: #edf2f7;">
                        <div class="col-lg-6 p-4 p-md-5">
                            <span class="badge bg-dark mb-3">Upgrade Your Everyday</span>
                            <h2 class="display-5 fw-bold mb-3">
                                Smart technology.<br>Better living.
                            </h2>
                            <p class="lead text-secondary mb-4">
                                Discover gadgets and electronics for work and play.
                            </p>
                            <a href="{{ route('products.index') }}"
                               class="btn btn-dark btn-lg px-4">
                                Explore Electronics
                                <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <img
                                src="https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=1200&q=85"
                                class="d-block w-100"
                                alt="Electronics and technology"
                                style="height: 390px; object-fit: cover;">
                        </div>
                    </div>
                </div>

                <!-- Slide 3: Home and Living -->
                <div class="carousel-item">
                    <div class="row align-items-center g-0"
                         style="min-height: 390px; background: #f3eee7;">
                        <div class="col-lg-6 p-4 p-md-5">
                            <span class="badge bg-dark mb-3">Make Yourself at Home</span>
                            <h2 class="display-5 fw-bold mb-3">
                                Comfort in every corner.
                            </h2>
                            <p class="lead text-secondary mb-4">
                                Find thoughtful touches for a more beautiful home.
                            </p>
                            <a href="{{ route('products.index') }}"
                               class="btn btn-dark btn-lg px-4">
                                Shop Home & Living
                                <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <img
                                src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=85"
                                class="d-block w-100"
                                alt="Modern home interior"
                                style="height: 390px; object-fit: cover;">
                        </div>
                    </div>
                </div>

            </div>

            <button class="carousel-control-prev" type="button"
                    data-bs-target="#homeHeroSlider" data-bs-slide="prev"
                    aria-label="Previous slide">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"
                      aria-hidden="true"></span>
            </button>

            <button class="carousel-control-next" type="button"
                    data-bs-target="#homeHeroSlider" data-bs-slide="next"
                    aria-label="Next slide">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-3"
                      aria-hidden="true"></span>
            </button>
        </div>
    </div>
</section>


<section class="py-5 bg-light" id="shop-categories">
    <div class="container">

        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
            <div>
                <span class="text-secondary small text-uppercase fw-semibold">
                    Find your favorites
                </span>
                <h2 class="fw-bold mb-1">Shop by Category</h2>
                <p class="text-secondary mb-0">
                    Explore products for every part of your life.
                </p>
            </div>

            <a href="{{ route('categories.index') }}"
               class="btn btn-outline-dark">
                View All Categories <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3 g-lg-4">
            @forelse($categories ?? [] as $category)
                @php
                    $categoryIcons = [
                        'fashion' => 'bi-bag',
                        'electronics' => 'bi-headphones',
                        'home & living' => 'bi-house-heart',
                        'home' => 'bi-house-heart',
                        'beauty' => 'bi-stars',
                        'health' => 'bi-heart-pulse',
                        'sports' => 'bi-dribbble',
                        'toys' => 'bi-controller',
                        'books' => 'bi-book',
                        'food' => 'bi-cup-hot',
                    ];

                    $categoryIcon = $categoryIcons[
                        strtolower(trim($category->name))
                    ] ?? 'bi-grid';
                @endphp

                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('categories.show', $category->slug) }}"                       class="text-decoration-none text-dark">
                        <div class="card border-0 shadow-sm rounded-4 h-100 category-card">
                            <div class="card-body p-4 d-flex align-items-center gap-3">
                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width: 56px; height: 56px;">
                                    @if($category->image)
                                        <img
                                            src="{{ asset('storage/' . $category->image) }}"
                                            alt="{{ $category->name }}"
                                            class="rounded-3 w-100 h-100"
                                            style="object-fit: cover;">
                                    @else
                                        <i class="bi {{ $categoryIcon }} fs-3"></i>
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <h6 class="fw-bold mb-1">
                                        {{ $category->name }}
                                    </h6>
                                    <span class="small text-secondary">
                                        Explore collection
                                    </span>
                                </div>

                                <i class="bi bi-chevron-right ms-auto text-secondary"></i>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-4">
                        <i class="bi bi-grid display-5 text-secondary"></i>
                        <p class="text-secondary mt-3 mb-0">
                            Categories will appear here soon.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</section>



 
<section class="py-5 bg-white">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Featured Products</h2>
                <p class="text-secondary mb-0">
                    Popular products picked for you
                </p>
            </div>

            <a href="{{ route('products.index') }}"
               class="btn btn-outline-dark">
                View All
            </a>
        </div>

        <div class="row g-4">

            @forelse($featuredProducts ?? [] as $product)

                @php
                    $primaryImage = $product->images->firstWhere('is_primary', true)
                        ?? $product->images->first();

                    $displayPrice = $product->sale_price !== null
                        && (float) $product->sale_price > 0
                        ? $product->sale_price
                        : $product->price;
                @endphp

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card product-card h-100 shadow-sm">

                        <a href="{{ route('products.show', $product->slug) }}"
                           class="text-decoration-none text-dark">

                            <div class="d-flex align-items-center justify-content-center bg-light"
                                 style="height: 220px; overflow: hidden;">

                                @if($primaryImage)
                                    <img
                                        src="{{ asset('storage/' . $primaryImage->path) }}"
                                        alt="{{ $primaryImage->alt_text ?? $product->name }}"
                                        style="width: 100%; height: 100%; object-fit: contain;"
                                    >
                                @else
                                    <i class="bi bi-image display-4 text-secondary"></i>
                                @endif

                            </div>

                            <div class="card-body">
                                <small class="text-secondary">
                                    {{ $product->category?->name ?? 'Product' }}
                                </small>

                                <h5 class="fw-semibold mt-1">
                                    {{ $product->name }}
                                </h5>

                                <div class="mt-3">
                                    <span class="fw-bold">
                                        ${{ number_format((float) $displayPrice, 2) }}
                                    </span>

                                    @if($product->sale_price !== null
                                        && (float) $product->sale_price > 0
                                        && (float) $product->sale_price < (float) $product->price)
                                        <del class="text-secondary ms-2">
                                            ${{ number_format((float) $product->price, 2) }}
                                        </del>
                                    @endif
                                </div>
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
                    <div class="text-center py-5">
                        <i class="bi bi-box-seam display-4 text-secondary"></i>
                        <h5 class="mt-3">No featured products available</h5>
                        <p class="text-secondary">
                            Check back soon for our latest products.
                        </p>
                    </div>
                </div>

            @endforelse

        </div>
    </div>
</section>


    <!-- Why Shop With Us -->
    <section class="py-5">

        <div class="container">

            <div class="text-center mb-5">

                <h2 class="fw-bold">
                    Why Shop With Us?
                </h2>

                <p class="text-secondary">
                    A better shopping experience from start to finish.
                </p>

            </div>


            <div class="row g-4">

                <div class="col-md-4">

                    <div class="text-center">

                        <i class="bi bi-truck display-5"></i>

                        <h5 class="fw-bold mt-3">
                            Fast Delivery
                        </h5>

                        <p class="text-secondary">
                            Reliable shipping options for your orders.
                        </p>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="text-center">

                        <i class="bi bi-shield-check display-5"></i>

                        <h5 class="fw-bold mt-3">
                            Secure Shopping
                        </h5>

                        <p class="text-secondary">
                            Your shopping experience is designed with security in mind.
                        </p>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="text-center">

                        <i class="bi bi-headset display-5"></i>

                        <h5 class="fw-bold mt-3">
                            Customer Support
                        </h5>

                        <p class="text-secondary">
                            We're here to help when you need us.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection