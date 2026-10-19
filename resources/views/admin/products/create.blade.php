@extends('layouts.admin.app')

@section('title', 'Add Product')
@section('page_title', 'Add Product')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Add Product</h2>
            <p class="text-secondary mb-0">Add a new product to your store catalog.</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Products
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST"
          action="{{ route('admin.products.store') }}"
          enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            {{-- Main product information --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Product Information</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Product Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                   class="form-control form-control-lg"
                                   value="{{ old('name') }}"
                                   placeholder="e.g. Wireless Headphones"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="sku" class="form-label fw-semibold">SKU</label>
                            <input type="text" id="sku" name="sku"
                                   class="form-control"
                                   value="{{ old('sku') }}"
                                   placeholder="e.g. HEADPHONE-001">
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label fw-semibold">
                                Short Description
                            </label>
                            <textarea id="short_description" name="short_description"
                                      class="form-control" rows="3"
                                      placeholder="A brief summary for product listings">{{ old('short_description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                Full Description
                            </label>
                            <textarea id="description" name="description"
                                      class="form-control" rows="7"
                                      placeholder="Describe the product and its features">{{ old('description') }}</textarea>
                        </div>

                        <hr class="my-4">

                        <h5 class="fw-bold mb-3">Product Image</h5>
                        <p class="text-secondary small">
                            Upload the main image customers will see in your store.
                        </p>

                        <label for="image" class="form-label fw-semibold">
                            Choose Image
                        </label>
                        <input type="file"
                               id="image"
                               name="image"
                               class="form-control"
                               accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

                        <div class="form-text">
                            JPG, JPEG, PNG or WebP. Maximum file size: 2 MB.
                        </div>

                        <div id="image-preview-container"
                             class="mt-3 p-3 border rounded-3 text-center d-none">
                            <img id="image-preview"
                                 src=""
                                 alt="Selected product image preview"
                                 class="img-fluid rounded"
                                 style="max-height: 280px; object-fit: contain;">

                            <div class="mt-2">
                                <span id="image-file-name" class="small text-secondary"></span>
                            </div>

                            <button type="button"
                                    id="remove-image"
                                    class="btn btn-sm btn-outline-danger mt-2">
                                <i class="bi bi-trash me-1"></i>Remove Image
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Pricing --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Pricing</h5>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="price" class="form-label fw-semibold">
                                    Regular Price <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="price" name="price"
                                       class="form-control" min="0" step="0.01"
                                       value="{{ old('price') }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="sale_price" class="form-label fw-semibold">
                                    Sale Price
                                </label>
                                <input type="number" id="sale_price" name="sale_price"
                                       class="form-control" min="0" step="0.01"
                                       value="{{ old('sale_price') }}">
                            </div>

                            <div class="col-md-4">
                                <label for="cost_price" class="form-label fw-semibold">
                                    Cost Price
                                </label>
                                <input type="number" id="cost_price" name="cost_price"
                                       class="form-control" min="0" step="0.01"
                                       value="{{ old('cost_price') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEO --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Search Engine Optimization</h5>

                        <div class="mb-3">
                            <label for="meta_title" class="form-label fw-semibold">
                                Meta Title
                            </label>
                            <input type="text" id="meta_title" name="meta_title"
                                   class="form-control" maxlength="255"
                                   value="{{ old('meta_title') }}">
                        </div>

                        <div>
                            <label for="meta_description" class="form-label fw-semibold">
                                Meta Description
                            </label>
                            <textarea id="meta_description" name="meta_description"
                                      class="form-control" rows="3">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Organization</h5>

                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-semibold">
                                Category
                            </label>
                            <select id="category_id" name="category_id" class="form-select">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @selected(old('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="brand_id" class="form-label fw-semibold">Brand</label>
                            <select id="brand_id" name="brand_id" class="form-select">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        @selected(old('brand_id') == $brand->id)>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Publishing --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Publishing</h5>

                        <label for="status" class="form-label fw-semibold">
                            Product Status
                        </label>
                        <select id="status" name="status" class="form-select mb-3">
                            <option value="draft"
                                @selected(old('status', 'draft') === 'draft')>
                                Draft
                            </option>
                            <option value="published"
                                @selected(old('status') === 'published')>
                                Published
                            </option>
                        </select>

                        <div class="form-check">
                            <input type="checkbox" id="featured" name="featured"
                                   value="1" class="form-check-input"
                                   @checked(old('featured'))>
                            <label for="featured" class="form-check-label">
                                Featured Product
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <button type="submit" class="btn btn-dark btn-lg w-100 mb-2">
                            <i class="bi bi-check-circle me-2"></i>Create Product
                        </button>

                        <a href="{{ route('admin.products.index') }}"
                           class="btn btn-outline-secondary w-100">
                            Cancel
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('image');
    const previewContainer = document.getElementById('image-preview-container');
    const preview = document.getElementById('image-preview');
    const fileName = document.getElementById('image-file-name');
    const removeButton = document.getElementById('remove-image');

    let previewUrl = null;

    input.addEventListener('change', function () {
        const file = this.files && this.files[0];

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
            previewUrl = null;
        }

        if (!file) {
            previewContainer.classList.add('d-none');
            preview.removeAttribute('src');
            fileName.textContent = '';
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!allowedTypes.includes(file.type)) {
            alert('Please select a JPG, PNG, or WebP image.');
            input.value = '';
            previewContainer.classList.add('d-none');
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('The image must be 2 MB or smaller.');
            input.value = '';
            previewContainer.classList.add('d-none');
            return;
        }

        previewUrl = URL.createObjectURL(file);
        preview.src = previewUrl;
        fileName.textContent = file.name;
        previewContainer.classList.remove('d-none');
    });

    removeButton.addEventListener('click', function () {
        input.value = '';

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
            previewUrl = null;
        }

        preview.removeAttribute('src');
        fileName.textContent = '';
        previewContainer.classList.add('d-none');
    });
});
</script>
@endsection
