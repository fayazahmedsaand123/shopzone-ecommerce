@extends('layouts.admin')
@section('title', 'Edit Brand')
@section('page-title', 'Edit Brand')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="admin-table p-4">
            <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Brand Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $brand->name) }}">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $brand->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Status *</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ $brand->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $brand->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Logo</label>
                    @if($brand->logo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$brand->logo) }}" height="50" class="rounded border">
                        </div>
                    @endif
                    <input type="file" name="logo" class="form-control" accept="image/*">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">Update Brand</button>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection