@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('page_title', 'Dashboard')

@section('content')

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Dashboard
            </h3>

            <p class="text-secondary mb-0">
                Welcome back, {{ auth()->user()->name ?? 'Admin' }}.
            </p>
        </div>

        <div>
            <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-dark">
                <i class="bi bi-shop me-1"></i>
                View Store
            </a>
        </div>

    </div>


    <!-- Statistics -->
    <div class="row g-4 mb-4">

        <div class="col-sm-6 col-xl-3">

            <div class="admin-card p-4 h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <small class="text-secondary">
                            Products
                        </small>

                        <h3 class="fw-bold mt-2 mb-0">
                            {{ \App\Models\Product::count() }}
                        </h3>
                    </div>

                    <div class="bg-light rounded-3 p-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>

                </div>

            </div>

        </div>


        <div class="col-sm-6 col-xl-3">

            <div class="admin-card p-4 h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <small class="text-secondary">
                            Categories
                        </small>

                        <h3 class="fw-bold mt-2 mb-0">
                            {{ \App\Models\Category::count() }}
                        </h3>
                    </div>

                    <div class="bg-light rounded-3 p-3">
                        <i class="bi bi-grid fs-4"></i>
                    </div>

                </div>

            </div>

        </div>


        <div class="col-sm-6 col-xl-3">

            <div class="admin-card p-4 h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <small class="text-secondary">
                            Brands
                        </small>

                        <h3 class="fw-bold mt-2 mb-0">
                            {{ \App\Models\Brand::count() }}
                        </h3>
                    </div>

                    <div class="bg-light rounded-3 p-3">
                        <i class="bi bi-tags fs-4"></i>
                    </div>

                </div>

            </div>

        </div>


        <div class="col-sm-6 col-xl-3">

            <div class="admin-card p-4 h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <small class="text-secondary">
                            Customers
                        </small>

                        <h3 class="fw-bold mt-2 mb-0">
                            {{ \App\Models\User::count() }}
                        </h3>
                    </div>

                    <div class="bg-light rounded-3 p-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Quick Actions -->
    <div class="admin-card p-4">

        <div class="mb-4">

            <h5 class="fw-bold mb-1">
                Quick Actions
            </h5>

            <p class="text-secondary mb-0">
                Manage your store from the administration panel.
            </p>

        </div>


        <div class="row g-3">

            <div class="col-md-6 col-lg-3">

                <a href="{{ route('admin.products.create') }}"
                    class="btn btn-light w-100 py-3 text-start">
                    <i class="bi bi-plus-circle me-2"></i>
                    Add Product
                </a>

            </div>


            <div class="col-md-6 col-lg-3">

                <a href="{{ route('admin.categories.index') }}"
   			class="btn btn-light w-100 py-3 text-start">
   			 <i class="bi bi-grid me-2"></i>
   			 Manage Categories
		</a>

            </div>


            <div class="col-md-6 col-lg-3">

                <a href="#"
                   class="btn btn-light w-100 py-3 text-start">

                    <i class="bi bi-tags me-2"></i>

                    Manage Brands

                </a>

            </div>


            <div class="col-md-6 col-lg-3">

                <a href="#"
                   class="btn btn-light w-100 py-3 text-start">

                    <i class="bi bi-gear me-2"></i>

                    Store Settings

                </a>

            </div>

        </div>

    </div>

@endsection