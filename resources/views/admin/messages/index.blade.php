@extends('layouts.admin')
@section('title', 'Messages')
@section('page-title', 'Contact Messages')

@section('content')
<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $msg)
            <tr id="row-{{ $msg->id }}" class="{{ $msg->status === 'unread' ? 'fw-semibold' : '' }}">
                <td style="font-size:13px;">{{ $msg->name }}</td>
                <td style="font-size:13px;">{{ $msg->email }}</td>
                <td style="font-size:13px;">{{ $msg->subject }}</td>
                <td>
                    <span class="badge bg-{{ $msg->status === 'unread' ? 'danger' : 'success' }}">
                        {{ ucfirst($msg->status) }}
                    </span>
                </td>
                <td style="font-size:12px;">{{ $msg->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.messages.show', $msg) }}"
                        class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger"
                        onclick="confirmDelete('{{ route('admin.messages.destroy', $msg) }}', '#row-{{ $msg->id }}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-4 text-muted">No messages yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3">{{ $messages->links() }}</div>
</div>
@endsection