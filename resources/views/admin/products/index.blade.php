<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .container {
            max-width: 1400px;
            margin: auto;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            background: #111827;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            border: 0;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f9fafb;
        }

        .success {
            padding: 12px;
            background: #dcfce7;
            color: #166534;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .edit {
            background: #2563eb;
        }

        .delete {
            background: #dc2626;
        }

        .product-image {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            display: block;
        }

        .no-image {
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            color: #6b7280;
            border-radius: 6px;
            font-size: 11px;
            text-align: center;
        }

        .pagination {
            margin-top: 20px;
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Products</h1>
            <p>Manage your store products.</p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="btn">
            + Add Product
        </a>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>SKU</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        @forelse($products as $product)
            @php
                $primaryImage = $product->images->firstWhere('is_primary', true)
                    ?? $product->images->first();
            @endphp

            <tr>
                <td>
                    @if($primaryImage)
                        <img
                            src="{{ asset('storage/' . $primaryImage->path) }}"
                            alt="{{ $primaryImage->alt_text ?? $product->name }}"
                            class="product-image"
                        >
                    @else
                        <div class="no-image">No image</div>
                    @endif
                </td>

                <td>{{ $product->name }}</td>
                <td>{{ $product->sku ?? '-' }}</td>
                <td>{{ $product->category?->name ?? '-' }}</td>
                <td>{{ $product->brand?->name ?? '-' }}</td>
                <td>{{ number_format((float) $product->price, 2) }}</td>
                <td>{{ ucfirst($product->status) }}</td>

                <td>
                    <div class="actions">
                        <a
                            href="{{ route('admin.products.edit', $product) }}"
                            class="btn edit"
                        >
                            Edit
                        </a>

                        <form
                            method="POST"
                            action="{{ route('admin.products.destroy', $product) }}"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn delete"
                                onclick="return confirm('Delete this product?')"
                            >
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">No products found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="pagination">
        {{ $products->links() }}
    </div>

</div>
</body>
</html>
