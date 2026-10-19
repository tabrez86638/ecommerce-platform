
@extends('layouts.storefront')

@section('title', 'Create Account')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Create Account</h2>
                        <p class="text-muted">
                            Sign up to start shopping with us.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control form-control-lg"
                                value="{{ old('name') }}"
                                placeholder="Enter your full name"
                                autocomplete="name"
                                required
                                autofocus
                            >
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control form-control-lg"
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                autocomplete="email"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control form-control-lg"
                                placeholder="At least 8 characters"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                Confirm Password
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control form-control-lg"
                                placeholder="Re-enter your password"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        <div class="form-check mb-4">
                            <input
                                type="checkbox"
                                id="terms"
                                name="terms"
                                value="1"
                                class="form-check-input"
                                {{ old('terms') ? 'checked' : '' }}
                                required
                            >
                            <label for="terms" class="form-check-label">
                                I agree to the terms and conditions.
                            </label>
                        </div>

                        <button type="submit" class="btn btn-dark btn-lg w-100">
                            Create Account
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <span class="text-muted">Already have an account?</span>
                        <a href="{{ route('login') }}" class="fw-semibold text-dark">
                            Sign in
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
