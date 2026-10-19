<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Dashboard') - Ecommerce</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            background: #f5f6f8;
            color: #212529;
        }

        .admin-wrapper {
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 250px;
            min-height: 100vh;
            background: #111827;
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 1000;
        }

        .admin-brand {
            padding: 22px 20px;
            font-size: 1.25rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .admin-brand i {
            margin-right: 8px;
        }

        .admin-sidebar .nav-link {
            color: #9ca3af;
            padding: 11px 20px;
            margin: 2px 10px;
            border-radius: 8px;
            transition: .2s;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: #fff;
            background: #1f2937;
        }

        .admin-sidebar .nav-link i {
            width: 22px;
            margin-right: 8px;
        }

        .sidebar-heading {
            color: #6b7280;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 20px 20px 8px;
        }

        .admin-main {
            margin-left: 250px;
            min-height: 100vh;
        }

        .admin-topbar {
            height: 70px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .admin-content {
            padding: 30px;
        }

        .admin-card {
            border: 0;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,.04);
        }

        .mobile-menu-btn {
            display: none;
        }

        @media (max-width: 991.98px) {

            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform .25s ease;
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: inline-block;
            }

            .admin-content {
                padding: 20px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="admin-wrapper">

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">

        <div class="admin-brand">
            <i class="bi bi-shop"></i>
            Ecommerce
        </div>

        <div class="sidebar-heading">
            Main
        </div>

        <nav class="nav flex-column">

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

        </nav>

        <div class="sidebar-heading">
            Catalog
        </div>

        <nav class="nav flex-column">

            <a href="{{ route('admin.products.index') }}"
                class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                Products
            </a>

            <a href="{{ route('admin.categories.index') }}"
   		class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
    		<i class="bi bi-grid"></i>
    		Categories
	    </a>

            <a href="#" class="nav-link">
                <i class="bi bi-tags"></i>
                Brands
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-sliders"></i>
                Attributes
            </a>

        </nav>

        <div class="sidebar-heading">
            Sales
        </div>

        <nav class="nav flex-column">

            <a href="#" class="nav-link">
                <i class="bi bi-cart-check"></i>
                Orders
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-people"></i>
                Customers
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-ticket-perforated"></i>
                Coupons
            </a>

        </nav>

        <div class="sidebar-heading">
            Management
        </div>

        <nav class="nav flex-column">

            <a href="{{ route('admin.reviews.index') }}" class="nav-link">
                <i class="bi bi-star"></i>
                Reviews
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-bar-chart"></i>
                Reports
            </a>

            <a href="#" class="nav-link">
                <i class="bi bi-gear"></i>
                Settings
            </a>

        </nav>

    </aside>


    <!-- Main -->
    <div class="admin-main">

        <!-- Topbar -->
        <header class="admin-topbar">

            <div class="d-flex align-items-center gap-3">

                <button
                    class="btn btn-light mobile-menu-btn"
                    type="button"
                    onclick="toggleSidebar()"
                >
                    <i class="bi bi-list fs-5"></i>
                </button>

                <h5 class="mb-0 fw-semibold">
                    @yield('page_title', 'Dashboard')
                </h5>

            </div>


            <div class="d-flex align-items-center gap-3">

                <div class="text-end d-none d-sm-block">
                    <div class="fw-semibold">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </div>

                    <small class="text-secondary">
                        Administrator
                    </small>
                </div>

                <div class="dropdown">

                    <button
                        class="btn btn-light rounded-circle"
                        data-bs-toggle="dropdown"
                    >
                        <i class="bi bi-person"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person me-2"></i>
                                Profile
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form
                                method="POST"
                                action="{{ route('admin.logout') }}"
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

                </div>

            </div>

        </header>


        <!-- Content -->
        <main class="admin-content">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </main>

    </div>

</div>


<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

<script>
    function toggleSidebar() {
        document
            .getElementById('adminSidebar')
            .classList.toggle('show');
    }
</script>

@stack('scripts')

</body>
</html>