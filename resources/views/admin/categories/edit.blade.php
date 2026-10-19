@extends('layouts.admin.app')

@section('title', 'Edit Category')
@section('page_title', 'Edit Category')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Edit Category</h4>
        <p class="text-secondary mb-0">
            Update category information.
        </p>
    </div>

    <a href="{{ route('admin.categories.index') }}"
       class="btn btn-outline-dark">
        <i class="bi bi-arrow-left me-1"></i>
        Back to Categories
    </a>
</div>

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
    <div class="card-body p-4">

        <form method="POST"
              action="{{ route('admin.categories.update', $category) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row g-4">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Category Name *
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $category->name) }}"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Slug
                    </label>

                    <input type="text"
                           name="slug"
                           class="form-control"
                           value="{{ old('slug', $category->slug) }}">

                    <small class="text-secondary">
                        URL-friendly category name.
                    </small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Parent Category
                    </label>

                    <select name="parent_id" class="form-select">

                        <option value="">
                            None (Top-level category)
                        </option>

                        @foreach($categories as $parent)
                            <option value="{{ $parent->id }}"
                                @selected(old('parent_id', $category->parent_id) == $parent->id)>
                                {{ $parent->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Sort Order
                    </label>

                    <input type="number"
                           name="sort_order"
                           class="form-control"
                           min="0"
                           value="{{ old('sort_order', $category->sort_order) }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">
                        Description
                    </label>

                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Category Image
                    </label>

                    @if($category->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $category->image) }}"
                                 alt="{{ $category->name }}"
                                 style="width:150px;height:120px;object-fit:cover;border-radius:8px;">

                            <p class="small text-secondary mt-1">
                                Current image
                            </p>
                        </div>
                    @endif

                    <input type="file"
                           id="image"
                           name="image"
                           class="form-control"
                           accept=".jpg,.jpeg,.png,.webp">

                    <small class="text-secondary">
                        Upload a new image to replace the current image.
                        Maximum size: 2 MB.
                    </small>

                    <div id="preview-container" class="mt-3 d-none">
                        <img id="image-preview"
                             alt="New category image preview"
                             style="width:150px;height:120px;object-fit:cover;border-radius:8px;">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold d-block">
                        Status
                    </label>

                    <div class="form-check form-switch mt-2">
                        <input type="checkbox"
                               name="is_active"
                               id="is_active"
                               value="1"
                               class="form-check-input"
                               @checked(old('is_active', $category->is_active) == 1)>

                        <label for="is_active" class="form-check-label">
                            Active Category
                        </label>
                    </div>
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">

                <button type="submit" class="btn btn-dark px-4">
                    <i class="bi bi-check-circle me-1"></i>
                    Update Category
                </button>

                <a href="{{ route('admin.categories.index') }}"
                   class="btn btn-outline-secondary px-4">
                    Cancel
                </a>

            </div>

        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('image');
    const preview = document.getElementById('image-preview');
    const container = document.getElementById('preview-container');

    let previewUrl = null;

    input.addEventListener('change', function () {
        const file = input.files[0];

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
            previewUrl = null;
        }

        if (!file) {
            container.classList.add('d-none');
            return;
        }

        const allowed = ['image/jpeg', 'image/png', 'image/webp'];

        if (!allowed.includes(file.type) || file.size > 2 * 1024 * 1024) {
            alert('Select a JPG, PNG, or WebP image under 2 MB.');
            input.value = '';
            container.classList.add('d-none');
            return;
        }

        previewUrl = URL.createObjectURL(file);
        preview.src = previewUrl;
        container.classList.remove('d-none');
    });
});
</script>
@endpush
