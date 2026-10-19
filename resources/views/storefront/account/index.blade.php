@extends('layouts.storefront')

@section('content')

<div class="container py-5">

    <div class="mb-4">
        <h2 class="fw-bold">My Account</h2>
        <p class="text-muted mb-0">
            Welcome back, {{ auth()->user()->name }}!
        </p>
    </div>

    <div class="row g-4">

        {{-- Account Menu --}}
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">

                    <div class="list-group list-group-flush">

                        <a href="{{ route('account.index') }}"
                           class="list-group-item list-group-item-action active">
                            <i class="bi bi-person me-2"></i>
                            Dashboard
                        </a>

                        <a href="{{ route('account.orders') }}" class="text-decoration-none">
                             <i class="bi bi-box-seam me-2"></i> My Orders
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="text-decoration-none d-block py-2">
                            <i class="bi bi-heart me-2"></i>
                                    My Wishlist
                        </a>

                        <a href="#"
                           class="list-group-item list-group-item-action">
                            <i class="bi bi-heart me-2"></i>
                            Wishlist
                        </a>

                        <a href="#"
                           class="list-group-item list-group-item-action">
                            <i class="bi bi-person-circle me-2"></i>
                            Profile
                        </a>

                        <a href="#"
                           class="list-group-item list-group-item-action">
                            <i class="bi bi-geo-alt me-2"></i>
                            Addresses
                        </a>

                    </div>

                    <hr>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                                class="btn btn-outline-danger w-100">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout
                        </button>
                    </form>

                </div>
            </div>
        </div>

        {{-- Dashboard --}}
        <div class="col-lg-9">

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-muted mb-1">Orders</p>
                                    <h3 class="fw-bold mb-0">{{ $ordersCount }}</h3>
                                </div>

                                <i class="bi bi-bag fs-2 text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-muted mb-1">Wishlist</p>
                                    <h3 class="fw-bold mb-0">{{ $wishlistCount }}</h3>
                                </div>

                                <i class="bi bi-heart fs-2 text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-muted mb-1">Reviews</p>
                                    <h3 class="fw-bold mb-0">0</h3>
                                </div>

                                <i class="bi bi-star fs-2 text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Account Information
                    </h5>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <small class="text-muted">
                                Name
                            </small>

                            <div class="fw-semibold">
                                {{ auth()->user()->name }}
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <small class="text-muted">
                                Email
                            </small>

                            <div class="fw-semibold">
                                {{ auth()->user()->email }}
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection