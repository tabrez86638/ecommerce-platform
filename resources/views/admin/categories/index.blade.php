@extends('layouts.admin.app')

@section('title', 'Categories')
@section('page_title', 'Categories')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Manage Categories</h4>
        <p class="text-secondary mb-0">Organize your store products.</p>
    </div>

    <a href="{{ route('admin.categories.create') }}" class="btn btn-dark">
        <i class="bi bi-plus-circle me-1"></i> Add Category
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card admin-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Category</th>
                        <th>Slug</th>
                        <th>Parent</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th>Sort Order</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                @if($category->image)
                                    <img
                                        src="{{ asset('storage/' . $category->image) }}"
                                        alt="{{ $category->name }}"
                                        style="width:48px;height:48px;object-fit:cover;border-radius:8px;"
                                    >
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                         style="width:48px;height:48px;">
                                        <i class="bi bi-grid text-secondary fs-4"></i>
                                    </div>
                                @endif

                                <span class="fw-semibold">{{ $category->name }}</span>
                            </div>
                        </td>

                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->parent?->name ?? '—' }}</td>
                        <td>
                            <span class="badge bg-light text-dark">
                                {{ $category->products_count }}
                            </span>
                        </td>

                        <td>
                            @if($category->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>

                        <td>{{ $category->sort_order }}</td>

                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.categories.destroy', $category) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this category?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-grid display-5 text-secondary"></i>
                            <h5 class="mt-3">No categories found</h5>
                            <p class="text-secondary">Create your first category to get started.</p>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-dark">
                                Add Category
                            </a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $categories->links() }}
</div>

@endsection
