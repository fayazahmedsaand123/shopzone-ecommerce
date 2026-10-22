@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h4>All Categories</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Category
    </a>
</div>

<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th width="60">Image</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Products</th>
                <th>Status</th>
                <th width="130">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr id="row-{{ $category->id }}">
                <td>
                    @if($category->image)
                        <img src="{{ asset('storage/'.$category->image) }}" width="44" height="44" class="rounded" style="object-fit:cover;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $category->name }}</strong>
                    <div class="text-muted" style="font-size:12px;">{{ $category->slug }}</div>
                </td>
                <td>{{ $category->parent->name ?? '—' }}</td>
                <td><span class="badge bg-secondary">{{ $category->products_count ?? $category->products()->count() }}</span></td>
                <td>
                    <span class="badge bg-{{ $category->status === 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($category->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger"
                        onclick="confirmDelete('{{ route('admin.categories.destroy', $category) }}', '#row-{{ $category->id }}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-4 text-muted">No categories found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3">{{ $categories->links() }}</div>
</div>
@endsection