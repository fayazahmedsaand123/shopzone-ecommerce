@extends('layouts.admin')
@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h4>All Products</h4>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Product
    </a>
</div>

{{-- Filters --}}
<div class="admin-table p-3 mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search name or SKU..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category_id" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
    </form>
</div>

<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th width="60">Image</th>
                <th>Product</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th width="100">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr id="row-{{ $product->id }}">
                <td>
                    @if($product->main_image)
                        <img src="{{ $product->image_url }}" width="44" height="44" class="rounded" style="object-fit:cover;">
                    @else
                        <div class="surface-soft rounded d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $product->name }}</strong>
                    <div class="text-muted" style="font-size:12px;">{{ $product->sku }}</div>
                </td>
                <td>{{ $product->category->name ?? '—' }}</td>
                <td>
                    @if($product->sale_price)
                        <span class="text-danger fw-bold">PKR {{ number_format($product->sale_price) }}</span>
                        <div><s class="text-muted" style="font-size:12px;">PKR {{ number_format($product->price) }}</s></div>
                    @else
                        PKR {{ number_format($product->price) }}
                    @endif
                </td>
                <td>
                    <span class="badge bg-{{ $product->stock_quantity <= 0 ? 'danger' : ($product->stock_quantity <= 5 ? 'warning' : 'success') }}">
                        {{ $product->stock_quantity }}
                    </span>
                </td>
                <td>
                    <span class="badge bg-{{ $product->status === 'active' ? 'success' : ($product->status === 'out_of_stock' ? 'warning' : 'secondary') }}">
                        {{ ucfirst(str_replace('_',' ',$product->status)) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger"
                        onclick="confirmDelete('{{ route('admin.products.destroy', $product) }}', '#row-{{ $product->id }}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-4 text-muted">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3">{{ $products->links() }}</div>
</div>
@endsection