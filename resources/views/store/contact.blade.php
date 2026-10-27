@extends('layouts.app')
@section('title', 'Contact Us — ShopZone')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold">Contact Us</h2>
        <p class="text-muted">We'd love to hear from you. Send us a message and we'll respond within 24 hours.</p>
    </div>

    <div class="row g-4 justify-content-center">

        {{-- Contact Info Cards --}}
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-3">

                <div class="bg-white rounded-3 border p-4 d-flex gap-3 align-items-start">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:50px;height:50px;font-size:20px;">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <div class="fw-bold mb-1">Our Address</div>
                        <div class="text-muted" style="font-size:13px;">
                            Naseem Nagar, Qasimabad<br>Hyderabad, Sindh, Pakistan
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3 border p-4 d-flex gap-3 align-items-start">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:50px;height:50px;font-size:20px;">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <div>
                        <div class="fw-bold mb-1">Phone / WhatsApp</div>
                        <div class="text-muted" style="font-size:13px;">
                            0349-9050580<br>0329-2073348
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3 border p-4 d-flex gap-3 align-items-start">
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:50px;height:50px;font-size:20px;">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <div class="fw-bold mb-1">Email</div>
                        <div class="text-muted" style="font-size:13px;">
                            support@shopzone.pk<br>
                            Mon–Sat, 9am–6pm
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3 border p-4">
                    <div class="fw-bold mb-2">Follow Us</div>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-danger btn-sm"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-outline-info btn-sm"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="btn btn-outline-success btn-sm"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Form --}}
        <div class="col-lg-6">
            <div class="bg-white rounded-3 border p-4">
                <h5 class="fw-bold mb-4">Send Us a Message</h5>

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:13px;">Full Name *</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', auth()->user()->name ?? '') }}"
                                placeholder="Your name">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:13px;">Email *</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', auth()->user()->email ?? '') }}"
                                placeholder="your@email.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:13px;">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone') }}" placeholder="03XX-XXXXXXX">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:13px;">Subject *</label>
                            <select name="subject" class="form-select @error('subject') is-invalid @enderror">
                                <option value="">Select subject</option>
                                <option value="Order Issue">Order Issue</option>
                                <option value="Product Inquiry">Product Inquiry</option>
                                <option value="Return & Refund">Return & Refund</option>
                                <option value="Payment Issue">Payment Issue</option>
                                <option value="General Inquiry">General Inquiry</option>
                            </select>
                            @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold" style="font-size:13px;">Message *</label>
                            <textarea name="message" rows="5"
                                class="form-control @error('message') is-invalid @enderror"
                                placeholder="Write your message here...">{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-5 fw-bold">
                                <i class="bi bi-send me-2"></i>Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection