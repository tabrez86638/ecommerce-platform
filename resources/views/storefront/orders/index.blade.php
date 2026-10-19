@extends('layouts.storefront')

@section('title', 'My Orders')

@section('content')

<div class="container py-5">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">My Orders</h1>
            <p class="text-muted mb-0">
                View and manage your recent orders.
            </p>
        </div>

        <a href="{{ route('home') }}" class="btn btn-outline-dark mt-3 mt-md-0">
            <i class="bi bi-arrow-left me-2"></i>
            Continue Shopping
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->count())

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="px-4">Order</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th class="text-end px-4">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($orders as $order)

                                <tr>

                                    <td class="px-4">
                                        <div class="fw-semibold">
                                            {{ $order->order_number }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $order->items->sum('quantity') }}
                                            {{ $order->items->sum('quantity') === 1 ? 'item' : 'items' }}   
                                        </small>
                                    </td>

                                    <td>
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>

                                    <td>
                                        @php
                                            $statusClass = match($order->status) {
                                                'completed' => 'success',
                                                'processing' => 'primary',
                                                'shipped' => 'info',
                                                'cancelled' => 'danger',
                                                default => 'warning',
                                            };
                                        @endphp

                                        <span class="badge text-bg-{{ $statusClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="text-capitalize">
                                            {{ str_replace('_', ' ', $order->payment_status) }}
                                        </span>
                                    </td>

                                    <td>
                                        <strong>
                                            ${{ number_format($order->total_amount, 2) }}
                                        </strong>
                                    </td>

                                    <td class="text-end px-4">
                                        <a href="{{ route('account.orders.show', $order) }}"
                                           class="btn btn-sm btn-outline-dark">
                                            View Order
                                        </a>
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>
                </div>

            </div>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>

    @else

        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">

                <div class="mb-3">
                    <i class="bi bi-box-seam display-4 text-muted"></i>
                </div>

                <h4 class="fw-bold">No orders yet</h4>

                <p class="text-muted mb-4">
                    You haven't placed any orders yet.
                </p>

                <a href="{{ route('home') }}" class="btn btn-dark">
                    Start Shopping
                </a>

            </div>
        </div>

    @endif

</div>

@endsection