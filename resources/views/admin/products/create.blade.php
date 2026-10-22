@extends('layouts.admin')
@section('title', 'Add Product')
@section('page-title', 'Add Product')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row g-4">

    {{-- Left Column --}}
    <div class="col-lg-8">
        <div class="admin-table p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Product Information</h6>

            <div class="mb-3">
                <label class="form-label fw-semibold">Product Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Enter product name">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Short Description</label>
                <textarea name="short_description" class="form-control" rows="2"
                    placeholder="Brief product summary (max 500 chars)">{{ old('short_description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Full Description</label>
                <textarea name="description" class="form-control" rows="6"
                    placeholder="Detailed product description">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="admin-table p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Pricing & Stock</h6>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Regular Price (PKR) *</label>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                        value="{{ old('price') }}" placeholder="0.00" step="0.01" min="0">
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Sale Price (PKR)</label>
                    <input type="number" name="sale_price" class="form-control"
                        value="{{ old('sale_price') }}" placeholder="0.00" step="0.01" min="0">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Stock Quantity *</label>
                    <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror"
                        value="{{ old('stock_quantity', 0) }}" min="0">
                    @error('stock_quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="admin-table p-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Product Images</h6>
            <div class="mb-3">
                <label class="form-label fw-semibold">Main Image</label>
                <input type="file" name="main_image" class="form-control" accept="image/*">
                <div class="form-text">Recommended: 800x800px. Max 3MB.</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Gallery Images</label>
                <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                <div class="form-text">Select multiple images for gallery.</div>
            </div>
        </div>
    </div>

    {{-- Right Column --}}
    <div class="col-lg-4">
        <div class="admin-table p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Organization</h6>

            <div class="mb-3">
                <label class="form-label fw-semibold">Category *</label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Brand</label>
                <select name="brand_id" class="form-select">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Status *</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="out_of_stock">Out of Stock</option>
                </select>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">Featured Product</label>
            </div>
        </div>

        <div class="admin-table p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Shipping</h6>
            <div class="mb-3">
                <label class="form-label fw-semibold">Weight (kg)</label>
                <input type="number" name="weight" class="form-control" value="{{ old('weight') }}" step="0.01" min="0">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Dimensions (L×W×H)</label>
                <input type="text" name="dimensions" class="form-control" value="{{ old('dimensions') }}" placeholder="e.g. 20×15×10 cm">
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-lg me-1"></i>Save Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>
@endsection