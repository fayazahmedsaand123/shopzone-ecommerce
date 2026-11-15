@extends('layouts.admin')
@section('title', 'Message Details')
@section('page-title', 'Message Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="admin-table p-4">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="fw-bold mb-0">{{ $message->subject }}</h5>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back
                </a>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="text-muted" style="font-size:12px;">FROM</label>
                    <div class="fw-semibold">{{ $message->name }}</div>
                </div>
                <div class="col-md-6">
                    <label class="text-muted" style="font-size:12px;">EMAIL</label>
                    <div><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></div>
                </div>
                @if($message->phone)
                <div class="col-md-6">
                    <label class="text-muted" style="font-size:12px;">PHONE</label>
                    <div>{{ $message->phone }}</div>
                </div>
                @endif
                <div class="col-md-6">
                    <label class="text-muted" style="font-size:12px;">DATE</label>
                    <div>{{ $message->created_at->format('d M Y, h:i A') }}</div>
                </div>
            </div>

            <div class="surface-soft rounded-3 p-4">
                <label class="text-muted mb-2" style="font-size:12px;">MESSAGE</label>
                <p class="mb-0" style="font-size:14px;line-height:1.8;">{{ $message->message }}</p>
            </div>

            <div class="mt-3">
                <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}"
                    class="btn btn-primary">
                    <i class="bi bi-reply me-2"></i>Reply via Email
                </a>
            </div>
        </div>
    </div>
</div>
@endsection