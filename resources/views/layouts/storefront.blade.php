<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('app.name', 'Ecommerce Store'))</title>

    <meta name="description" content="@yield('meta_description', 'Modern online shopping experience')">

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f8f9fa;
            color: #212529;
        }

        .store-header {
            background: #ffffff;
            border-bottom: 1px solid #e9ecef;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
        }

        .search-box {
            max-width: 500px;
            width: 100%;
        }

        .store-footer {
            background: #212529;
            color: #ffffff;
        }

        .store-footer a {
            color: #adb5bd;
            text-decoration: none;
        }

        .store-footer a:hover {
            color: #ffffff;
        }

        .product-card {
            border: 0;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .product-image {
            height: 240px;
            object-fit: cover;
            background: #f1f3f5;
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Header -->
    <header class="store-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">

                <a class="navbar-brand" href="{{ route('home') }}">
                    Ecommerce
                </a>

                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#storeNavbar"
                    aria-controls="storeNavbar"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="storeNavbar">

            
<form action="{{ route('products.index') }}" method="GET"
      class="d-flex align-items-center gap-2">
    <input
        type="search"
        name="search"
        class="form-control"
        placeholder="Search products..."
        value="{{ request('search') }}"
        aria-label="Search products"
    >

    <button type="submit" class="btn btn-dark">
        <i class="bi bi-search"></i>
    </button>
</form>

                    <ul class="navbar-nav ms-auto align-items-lg-center">

                        <!-- Home -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                Home
                            </a>
                        </li>

                        <!-- Categories -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('categories.index') }}">
                                Categories
                            </a>
                        </li>

                        <!-- Wishlist -->
                        <li class="nav-item">
                            <a href="{{ route('wishlist.index') }}" class="nav-link">
                            <i class="bi bi-heart"></i> Wishlist
                            </a>
                        </li>

                        <!-- Cart -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart3"></i>
                                Cart
                            </a>
                        </li>

                        <!-- Account -->
                        @auth

                            <li class="nav-item dropdown">

                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="accountDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    <i class="bi bi-person"></i>
                                    {{ auth()->user()->name }}
                                </a>

                                <ul
                                    class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="accountDropdown"
                                >

                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="{{ route('account.index') }}"
                                        >
                                            <i class="bi bi-person-circle me-2"></i>
                                            My Account
                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <form
                                            method="POST"
                                            action="{{ route('logout') }}"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="dropdown-item text-danger"
                                            >
                                                <i class="bi bi-box-arrow-right me-2"></i>
                                                Logout
                                            </button>
                                        </form>
                                    </li>

                                </ul>

                            </li>

                        @else

                            <li class="nav-item">
    <a class="nav-link" href="{{ route('login') }}">
        <i class="bi bi-person"></i>
        Login
    </a>
</li>

<!-- <li class="nav-item">
    <a class="nav-link" href="{{ route('register') }}">
        <i class="bi bi-person-plus"></i>
        Create Account
    </a>
</li> -->

                        @endauth

                    </ul>

                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
@if (session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="store-footer mt-5 pt-5 pb-4">

        <div class="container">

            <div class="row g-4">

                <div class="col-md-4">
                    <h5>Ecommerce</h5>
                    <p class="text-secondary">
                        Professional eCommerce, simple to deploy.
                    </p>
                </div>

                <div class="col-md-2">
                    <h6>Shop</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('products.index') }}">
                                Products
                            </a>
                        </li>

                        <li class="mb-2">
                            <a href="{{ route('categories.index') }}">
                                Categories
                            </a>
                        </li>

                        <li class="mb-2">
                            <a href="{{ route('wishlist.index') }}">
                                Wishlist
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-2">
                    <h6>Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('contact.index') }}">
                                Contact
                            </a>
                        </li>

                        <li class="mb-2">
                            <a href="#">
                                Shipping
                            </a>
                        </li>

                        <li class="mb-2">
                            <a href="#">
                                Returns
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h6>Follow Us</h6>

                    <div class="d-flex gap-3 fs-5">
                        <a href="#">
                            <i class="bi bi-facebook"></i>
                        </a>

                        <a href="#">
                            <i class="bi bi-instagram"></i>
                        </a>

                        <a href="#">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                    </div>
                </div>

            </div>

            <hr class="border-secondary my-4">

            <div class="text-center text-secondary">
                © {{ date('Y') }} Ecommerce. All rights reserved.
            </div>

        </div>

    </footer>

    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    @stack('scripts')

</body>
</html>