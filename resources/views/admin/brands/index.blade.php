@extends('layouts.admin')
@section('title', 'Brands')
@section('page-title', 'Brands')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h4>All Brands</h4>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Brand
    </a>
</div>

<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th width="60">Logo</th>
                <th>Name</th>
                <th>Products</th>
                <th>Status</th>
                <th width="130">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($brands as $brand)
            <tr id="row-{{ $brand->id }}">
                <td>
                    @if($brand->logo)
                        <img src="{{ asset('storage/'.$brand->logo) }}" width="44" height="44" class="rounded" style="object-fit:contain;">
                    @else
                        <div class="surface-soft rounded d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                            <i class="bi bi-award text-muted"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $brand->name }}</strong>
                    <div class="text-muted" style="font-size:12px;">{{ $brand->slug }}</div>
                </td>
                <td><span class="badge bg-secondary">{{ $brand->products()->count() }}</span></td>
                <td>
                    <span class="badge bg-{{ $brand->status === 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($brand->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger"
                        onclick="confirmDelete('{{ route('admin.brands.destroy', $brand) }}', '#row-{{ $brand->id }}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-4 text-muted">No brands found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3">{{ $brands->links() }}</div>
</div>
@endsection