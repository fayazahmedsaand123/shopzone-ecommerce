@extends('layouts.admin')
@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="row g-4">

    <div class="col-lg-8">
        <div class="admin-table p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Product Information</h6>
            <div class="mb-3">
                <label class="form-label fw-semibold">Product Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $product->name) }}">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Short Description</label>
                <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Full Description</label>
                <textarea name="description" class="form-control" rows="6">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="text-muted" style="font-size:12px;">SKU: {{ $product->sku }}</div>
        </div>

        <div class="admin-table p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Pricing & Stock</h6>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Regular Price (PKR) *</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" step="0.01" min="0">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Sale Price (PKR)</label>
                    <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Stock Quantity *</label>
                    <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0">
                </div>
            </div>
        </div>

        <div class="admin-table p-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Images</h6>
            @if($product->main_image)
                <div class="mb-2">
                    <label class="form-label fw-semibold">Current Main Image</label><br>
                    <img src="{{ asset('storage/'.$product->main_image) }}" height="80" class="rounded border">
                </div>
            @endif
            <div class="mb-3">
                <label class="form-label fw-semibold">Replace Main Image</label>
                <input type="file" name="main_image" class="form-control" accept="image/*">
            </div>

            @if($product->images->count())
                <div class="mb-2">
                    <label class="form-label fw-semibold">Current Gallery</label>
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach($product->images as $img)
                            <img src="{{ asset('storage/'.$img->image) }}" height="60" class="rounded border">
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="mb-3">
                <label class="form-label fw-semibold">Add More Gallery Images</label>
                <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-table p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Organization</h6>
            <div class="mb-3">
                <label class="form-label fw-semibold">Category *</label>
                <select name="category_id" class="form-select">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Brand</label>
                <select name="brand_id" class="form-select">
                    <option value="">No Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Status *</label>
                <select name="status" class="form-select">
                    <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="out_of_stock" {{ $product->status === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <div class="form-check">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ $product->is_featured ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">Featured Product</label>
            </div>
        </div>

        <div class="admin-table p-4 mb-4">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Shipping</h6>
            <div class="mb-3">
                <label class="form-label fw-semibold">Weight (kg)</label>
                <input type="number" name="weight" class="form-control" value="{{ old('weight', $product->weight) }}" step="0.01" min="0">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Dimensions</label>
                <input type="text" name="dimensions" class="form-control" value="{{ old('dimensions', $product->dimensions) }}">
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-lg me-1"></i>Update Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>
@endsection