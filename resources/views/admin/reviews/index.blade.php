@extends('layouts.admin.app')

@section('title', 'Reviews')

@section('page_title', 'Reviews')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            Product Reviews
        </h3>

        <p class="text-secondary mb-0">
            Manage customer reviews and approval status.
        </p>
    </div>

</div>


@if(session('success'))

    <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
    </div>

@endif


@if($reviews->count())

    <div class="admin-card">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th class="px-4">Customer</th>
                        <th>Product</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($reviews as $review)

                    <tr>

                        {{-- Customer --}}
                        <td class="px-4">

                            <div class="fw-semibold">
                                {{ $review->user->name ?? 'Unknown' }}
                            </div>

                            <small class="text-secondary">
                                {{ $review->user->email ?? '' }}
                            </small>

                        </td>


                        {{-- Product --}}
                        <td>

                            <div class="fw-semibold">
                                {{ $review->product->name ?? 'Deleted Product' }}
                            </div>

                            @if($review->order)

                                <small class="text-secondary">
                                    Order:
                                    {{ $review->order->order_number }}
                                </small>

                            @endif

                        </td>


                        {{-- Rating --}}
                        <td>

                            <div class="text-warning">

                                @for($i = 1; $i <= 5; $i++)

                                    @if($i <= $review->rating)
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif

                                @endfor

                            </div>

                            <small class="text-secondary">
                                {{ $review->rating }}/5
                            </small>

                        </td>


                        {{-- Review --}}
                        <td style="min-width: 250px;">

                            <div class="fw-semibold">
                                {{ $review->title }}
                            </div>

                            <div class="text-secondary small">
                                {{ \Illuminate\Support\Str::limit($review->comment, 100) }}
                            </div>

                        </td>


                        {{-- Status --}}
                        <td>

                            @php

                                $statusClass = match($review->status) {
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                    default => 'warning',
                                };

                            @endphp

                            <span class="badge text-bg-{{ $statusClass }}">
                                {{ ucfirst($review->status) }}
                            </span>

                        </td>


                        {{-- Date --}}
                        <td>

                            {{ $review->created_at->format('d M Y') }}

                        </td>


                        {{-- Actions --}}
                        <td class="text-end px-4">

                            <div class="d-flex justify-content-end gap-2">

                                @if($review->status !== 'approved')

                                    <form method="POST"
                                          action="{{ route('admin.reviews.approve', $review) }}">

                                        @csrf

                                        <button type="submit"
                                                class="btn btn-sm btn-success">

                                            <i class="bi bi-check-lg me-1"></i>
                                            Approve

                                        </button>

                                    </form>

                                @endif


                                @if($review->status !== 'rejected')

                                    <form method="POST"
                                          action="{{ route('admin.reviews.reject', $review) }}">

                                        @csrf

                                        <button type="submit"
                                                class="btn btn-sm btn-warning">

                                            <i class="bi bi-x-lg me-1"></i>
                                            Reject

                                        </button>

                                    </form>

                                @endif


                                <form method="POST"
                                      action="{{ route('admin.reviews.destroy', $review) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this review?');">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>


    @if($reviews->hasPages())

        <div class="mt-4">
            {{ $reviews->links() }}
        </div>

    @endif


@else

    <div class="admin-card text-center py-5">

        <i class="bi bi-chat-square-text display-4 text-secondary"></i>

        <h5 class="mt-3">
            No reviews found
        </h5>

        <p class="text-secondary mb-0">
            Customer reviews will appear here.
        </p>

    </div>

@endif

@endsection