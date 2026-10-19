@extends('layouts.storefront')

@section('title', 'Categories - Ecommerce')
@section('meta_description', 'Browse all product categories.')

@section('content')

{{-- Page Header --}}
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}"
                       class="text-decoration-none text-secondary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Categories
                </li>
            </ol>
        </nav>

        <h1 class="fw-bold mb-2">Shop by Category</h1>
        <p class="text-secondary mb-0">
            Explore products for every part of your life.
        </p>
    </div>
</section>

{{-- Category Grid --}}
<section class="py-4 bg-light">
    <div class="container">
        <div class="row g-3">

            @forelse($categories as $category)

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

                <div class="col-12 col-md-6 col-xl-3">
                    <a href="{{ route('categories.show', $category->slug) }}"
                       class="text-decoration-none text-dark d-block h-100">

                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-3 d-flex align-items-center gap-3">

                                {{-- Image or Icon --}}
                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width: 56px; height: 56px; overflow: hidden;">

                                    @if($category->image)
                                        <img
                                            src="{{ asset('storage/' . $category->image) }}"
                                            alt="{{ $category->name }}"
                                            class="w-100 h-100"
                                            style="object-fit: cover;"
                                            loading="lazy"
                                        >
                                    @else
                                        <i class="bi {{ $categoryIcon }} fs-3"
                                           aria-hidden="true"></i>
                                    @endif

                                </div>

                                {{-- Category Details --}}
                                <div class="flex-grow-1 min-w-0">
                                    <h6 class="fw-bold mb-1">
                                        {{ $category->name }}
                                    </h6>

                                    <p class="small text-secondary mb-0">
                                        {{ $category->description ?: 'Explore collection' }}
                                    </p>
                                </div>

                                {{-- Arrow --}}
                                <i class="bi bi-chevron-right text-secondary flex-shrink-0"
                                   aria-hidden="true"></i>

                            </div>
                        </div>

                    </a>
                </div>

            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-grid display-5 text-secondary"
                           aria-hidden="true"></i>
                        <p class="text-secondary mt-3 mb-0">
                            Categories will appear here soon.
                        </p>
                    </div>
                </div>
            @endforelse

        </div>
    </div>
</section>

@endsection