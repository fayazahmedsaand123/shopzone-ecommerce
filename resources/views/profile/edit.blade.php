@extends('layouts.app')
@section('title', 'Profile Settings — ShopZone')

@section('content')
<div class="container py-4" style="max-width:880px;">

    <div class="page-head pt-0">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Account</a></li>
                <li class="breadcrumb-item active">Profile Settings</li>
            </ol>
        </nav>
        <h1 class="page-title"><i class="bi bi-gear me-2"></i>Profile Settings</h1>
        <p class="page-sub">Update your account details, password and preferences.</p>
    </div>

    @if(session('status') === 'profile-updated')
        <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill"></i> Your profile has been updated.
        </div>
    @endif

    @if(session('status') === 'password-updated')
        <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-shield-check"></i> Your password has been updated.
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="col-12">
            @include('profile.partials.update-password-form')
        </div>

        <div class="col-12">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
