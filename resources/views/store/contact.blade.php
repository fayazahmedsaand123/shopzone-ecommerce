@extends('layouts.app')
@section('title', 'Contact Us — ShopZone')

@section('content')
<div class="container">
    <div class="page-head">
        <span class="eyebrow"><i class="bi bi-chat-dots"></i>Support</span>
        <h1 class="page-title mt-2">Contact us</h1>
        <p class="text-muted mb-0">We'd love to hear from you — send a message and we'll reply within 24 hours.</p>
    </div>

    <div class="row g-4 justify-content-center pb-5">
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-3">
                <div class="contact-card">
                    <div class="icon"><i class="bi bi-geo-alt"></i></div>
                    <div>
                        <div class="t">Our address</div>
                        <div class="s">Naseem Nagar, Qasimabad<br>Hyderabad, Sindh, Pakistan</div>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="icon"><i class="bi bi-telephone"></i></div>
                    <div>
                        <div class="t">Phone / WhatsApp</div>
                        <div class="s">0349-9050580<br>0329-2073348</div>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="icon"><i class="bi bi-envelope"></i></div>
                    <div>
                        <div class="t">Email</div>
                        <div class="s">support@shopzone.pk<br>Mon–Sat, 9am–6pm</div>
                    </div>
                </div>

                <div class="panel panel-pad">
                    <div class="fw-bold mb-2">Follow us</div>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-btn" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-btn" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-btn" aria-label="X"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-btn" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="panel panel-pad">
                <h2 class="h5 fw-bold mb-1">Send us a message</h2>
                <p class="text-muted small mb-4">Fields marked * are required.</p>

                @if(session('success'))
                    <div class="flash success mb-3">
                        <i class="bi bi-check-circle-fill"></i>{{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', auth()->user()->name ?? '') }}" placeholder="Your name">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="you@example.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="03XX-XXXXXXX">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Subject *</label>
                            <select name="subject" class="form-select @error('subject') is-invalid @enderror">
                                <option value="">Select subject</option>
                                <option value="Order Issue">Order Issue</option>
                                <option value="Product Inquiry">Product Inquiry</option>
                                <option value="Return & Refund">Return &amp; Refund</option>
                                <option value="Payment Issue">Payment Issue</option>
                                <option value="General Inquiry">General Inquiry</option>
                            </select>
                            @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Message *</label>
                            <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror"
                                placeholder="Write your message here...">{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg">
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
