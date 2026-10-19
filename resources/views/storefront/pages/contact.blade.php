@extends('layouts.storefront')

@section('title', 'Contact Us')

@section('content')
<div class="container py-5">

    <div class="text-center mb-5">
        <span class="badge bg-light text-dark border mb-3">
            WE'RE HERE TO HELP
        </span>

        <h1 class="fw-bold display-5">Contact Us</h1>

        <p class="text-secondary mt-3">
            Have a question about your order or our products?
            We'd love to hear from you.
        </p>
    </div>

    <div class="row g-4 justify-content-center">

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 p-lg-5">

                    <h4 class="fw-bold mb-4">Get in touch</h4>

                    <div class="d-flex gap-3 mb-4">
                        <div class="fs-4 text-secondary">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Email</h6>
                            <p class="text-secondary mb-0">
                                Contact our support team for assistance.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-4">
                        <div class="fs-4 text-secondary">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Support hours</h6>
                            <p class="text-secondary mb-0">
                                Monday – Friday
                            </p>
                        </div>
                    </div>

                    <div class="alert alert-light border mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        For order-related questions, please include your order number.
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-5">

                    <h4 class="fw-bold mb-2">Send us a message</h4>
			@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                    <p class="text-secondary mb-4">
                        Fill in the details below and we'll be happy to help.
                    </p>

                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="contact_name" class="form-label">
                                    Your Name
                                </label>
                                <input
                                    type="text"
                                    id="contact_name"
                                    name="name"
                                    class="form-control"
                                    placeholder="Enter your name"
                                    required
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="contact_email" class="form-label">
                                    Email Address
                                </label>
                                <input
                                    type="email"
                                    id="contact_email"
                                    name="email"
                                    class="form-control"
                                    placeholder="you@example.com"
                                    required
                                >
                            </div>

                            <div class="col-12">
                                <label for="contact_subject" class="form-label">
                                    Subject
                                </label>
                                <input
                                    type="text"
                                    id="contact_subject"
                                    name="subject"
                                    class="form-control"
                                    placeholder="How can we help?"
                                    required
                                >
                            </div>

                            <div class="col-12">
                                <label for="contact_message" class="form-label">
                                    Message
                                </label>
                                <textarea
                                    id="contact_message"
                                    name="message"
                                    class="form-control"
                                    rows="5"
                                    placeholder="Write your message here..."
                                    required
                                ></textarea>
                            </div>

                            <div class="col-12">
                               <button type="submit" class="btn btn-dark btn-lg w-100">
                                 <i class="bi bi-send me-2"></i>
                                     Send Message
                                </button>

                                <small class="text-secondary d-block mt-2">
                                    Message submission will be enabled in the next step.
                                </small>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
