@extends('layouts.admin.app')

@section('title', 'Add Category')
@section('page_title', 'Add Category')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Add Category</h4>
        <p class="text-secondary mb-0">Create a category for your store.</p>
    </div>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark">
        <i class="bi bi-arrow-left me-1"></i> Back to Categories
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
              action="{{ route('admin.categories.store') }}"
              enctype="multipart/form-data">

            @csrf

            <div class="row g-4">

                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold">
                        Category Name <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        placeholder="e.g. Electronics"
                        maxlength="255"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label for="slug" class="form-label fw-semibold">
                        Slug <span class="text-secondary">(Optional)</span>
                    </label>
                    <input
                        type="text"
                        id="slug"
                        name="slug"
                        class="form-control"
                        value="{{ old('slug') }}"
                        placeholder="e.g. electronics"
                        maxlength="255"
                    >
                    <small class="text-secondary">
                        Leave blank to generate it from the category name.
                    </small>
                </div>

                <div class="col-md-6">
                    <label for="parent_id" class="form-label fw-semibold">
                        Parent Category
                    </label>
                    <select id="parent_id" name="parent_id" class="form-select">
                        <option value="">None (Top-level category)</option>
                        @foreach($categories as $parent)
                            <option
                                value="{{ $parent->id }}"
                                @selected(old('parent_id') == $parent->id)
                            >
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="sort_order" class="form-label fw-semibold">
                        Sort Order
                    </label>
                    <input
                        type="number"
                        id="sort_order"
                        name="sort_order"
                        class="form-control"
                        value="{{ old('sort_order', 0) }}"
                        min="0"
                    >
                    <small class="text-secondary">
                        Lower numbers appear first.
                    </small>
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">
                        Description
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="4"
                        placeholder="Describe this category..."
                    >{{ old('description') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label for="image" class="form-label fw-semibold">
                        Category Image
                    </label>
                    <input
                        type="file"
                        id="image"
                        name="image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    >
                    <small class="text-secondary">
                        JPG, PNG or WebP. Maximum size: 2 MB.
                    </small>

                    <div id="image-preview-container" class="mt-3 d-none">
                        <img
                            id="image-preview"
                            src=""
                            alt="Category image preview"
                            style="width:150px;height:120px;object-fit:cover;border-radius:8px;"
                        >
                        <div id="image-file-name" class="small text-secondary mt-1"></div>
                        <button type="button" id="remove-image"
                                class="btn btn-sm btn-outline-danger mt-2">
                            Remove Image
                        </button>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold d-block">Status</label>

                    <div class="form-check form-switch mt-2">
                        <input
                            type="checkbox"
                            id="is_active"
                            name="is_active"
                            value="1"
                            class="form-check-input"
                            role="switch"
                            @checked(old('is_active', '1') == '1')
                        >
                        <label for="is_active" class="form-check-label">
                            Active category
                        </label>
                    </div>

                    <small class="text-secondary">
                        Active categories can be offered to customers.
                    </small>
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark px-4">
                    <i class="bi bi-check-circle me-1"></i> Create Category
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
    const container = document.getElementById('image-preview-container');
    const preview = document.getElementById('image-preview');
    const fileName = document.getElementById('image-file-name');
    const removeButton = document.getElementById('remove-image');
    const slugInput = document.getElementById('slug');
    const nameInput = document.getElementById('name');

    let previewUrl = null;
    let slugManuallyEdited = false;

    slugInput.addEventListener('input', function () {
        slugManuallyEdited = slugInput.value.trim() !== '';
    });

    nameInput.addEventListener('input', function () {
        if (!slugManuallyEdited) {
            slugInput.value = nameInput.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }
    });

    input.addEventListener('change', function () {
        const file = input.files[0];

        if (!file) return;

        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!allowedTypes.includes(file.type)) {
            alert('Please select a JPG, PNG, or WebP image.');
            input.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('The image must be smaller than 2 MB.');
            input.value = '';
            return;
        }

        if (previewUrl) URL.revokeObjectURL(previewUrl);

        previewUrl = URL.createObjectURL(file);
        preview.src = previewUrl;
        fileName.textContent = file.name;
        container.classList.remove('d-none');
    });

    removeButton.addEventListener('click', function () {
        input.value = '';
        preview.src = '';

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
            previewUrl = null;
        }

        fileName.textContent = '';
        container.classList.add('d-none');
    });
});
</script>
@endpush