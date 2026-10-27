@extends('layouts.app')
@section('title', 'Checkout — ShopZone')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4"><i class="bi bi-lock me-2"></i>Secure Checkout</h4>

    <form method="POST" action="{{ route('customer.checkout.place') }}">
    @csrf
    <div class="row g-4">

        {{-- Left: Shipping Info --}}
        <div class="col-lg-7">
            <div class="bg-white rounded-3 border p-4 mb-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">
                    <i class="bi bi-geo-alt me-2 text-primary"></i>Shipping Information
                </h6>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name *</label>
                    <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                        value="{{ old('full_name', auth()->user()->name) }}">
                    @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address *</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', auth()->user()->email) }}"
                        placeholder="your@email.com">
                    <div class="form-text">Order confirmation will be sent to this email.</div>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Phone Number *</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', auth()->user()->phone) }}" placeholder="03XX-XXXXXXX">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Complete Address *</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                        rows="3" placeholder="House #, Street, Area">{{ old('address') }}</textarea>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">City *</label>
                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                        value="{{ old('city') }}" placeholder="e.g. Karachi, Lahore, Hyderabad">
                    @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Order Notes (Optional)</label>
                    <textarea name="order_notes" class="form-control" rows="2"
                        placeholder="Any special instructions...">{{ old('order_notes') }}</textarea>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="bg-white rounded-3 border p-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">
                    <i class="bi bi-credit-card me-2 text-primary"></i>Payment Method
                </h6>

                {{-- Payment Options --}}
                <div class="d-flex flex-column gap-3" id="payment-options">

                    {{-- Cash on Delivery --}}
                    <div class="payment-option border rounded-3 p-3" data-method="cod">
                        <div class="form-check">
                            <input class="form-check-input payment-radio" type="radio"
                                name="payment_method" value="cod" id="pay_cod" checked>
                            <label class="form-check-label d-flex align-items-center gap-3 w-100" for="pay_cod" style="cursor:pointer;">
                                <div class="payment-icon rounded-2 d-flex align-items-center justify-content-center"
                                    style="width:48px;height:48px;background:#e8f5e9;font-size:22px;">
                                    💵
                                </div>
                                <div>
                                    <div class="fw-bold" style="font-size:14px;">Cash on Delivery</div>
                                    <div class="text-muted" style="font-size:12px;">Pay when your order arrives at your door</div>
                                </div>
                                <span class="ms-auto badge bg-success">Available</span>
                            </label>
                        </div>
                    </div>

                    {{-- JazzCash --}}
                    <div class="payment-option border rounded-3 p-3" data-method="jazzcash">
                        <div class="form-check">
                            <input class="form-check-input payment-radio" type="radio"
                                name="payment_method" value="jazzcash" id="pay_jazz">
                            <label class="form-check-label d-flex align-items-center gap-3 w-100" for="pay_jazz" style="cursor:pointer;">
                                <div class="payment-icon rounded-2 d-flex align-items-center justify-content-center"
                                    style="width:48px;height:48px;background:#fff3e0;font-size:22px;">
                                    📱
                                </div>
                                <div>
                                    <div class="fw-bold" style="font-size:14px;">JazzCash</div>
                                    <div class="text-muted" style="font-size:12px;">Send payment to: <strong>0329-2073348</strong></div>
                                </div>
                                <span class="ms-auto badge bg-warning text-dark">Manual</span>
                            </label>
                        </div>
                        {{-- JazzCash Details --}}
                        <div class="payment-details mt-3 ps-4" style="display:none;">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3 mb-3">
                                <div class="fw-bold mb-1" style="font-size:13px;"><i class="bi bi-info-circle me-1"></i>Payment Instructions</div>
                                <ol class="mb-0 ps-3" style="font-size:12px;color:#6c757d;">
                                    <li>Open your JazzCash app</li>
                                    <li>Send <strong>PKR {{ number_format($total) }}</strong> to <strong>0329-2073348</strong></li>
                                    <li>Enter the transaction ID and your account number below</li>
                                    <li>We will verify and confirm your order within 1 hour</li>
                                </ol>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:12px;">Transaction ID *</label>
                                    <input type="text" name="transaction_id" class="form-control form-control-sm"
                                        placeholder="e.g. TXN123456789">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:12px;">Your JazzCash Number *</label>
                                    <input type="text" name="account_number" class="form-control form-control-sm"
                                        placeholder="03XX-XXXXXXX">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Easypaisa --}}
                    <div class="payment-option border rounded-3 p-3" data-method="easypaisa">
                        <div class="form-check">
                            <input class="form-check-input payment-radio" type="radio"
                                name="payment_method" value="easypaisa" id="pay_easy">
                            <label class="form-check-label d-flex align-items-center gap-3 w-100" for="pay_easy" style="cursor:pointer;">
                                <div class="payment-icon rounded-2 d-flex align-items-center justify-content-center"
                                    style="width:48px;height:48px;background:#e8f5e9;font-size:22px;">
                                    💚
                                </div>
                                <div>
                                    <div class="fw-bold" style="font-size:14px;">Easypaisa</div>
                                    <div class="text-muted" style="font-size:12px;">Send payment to: <strong>0349-9050580</strong></div>
                                </div>
                                <span class="ms-auto badge bg-success">Available</span>
                            </label>
                        </div>
                        <div class="payment-details mt-3 ps-4" style="display:none;">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3 mb-3">
                                <div class="fw-bold mb-1" style="font-size:13px;"><i class="bi bi-info-circle me-1"></i>Payment Instructions</div>
                                <ol class="mb-0 ps-3" style="font-size:12px;color:#6c757d;">
                                    <li>Open your Easypaisa app</li>
                                    <li>Send <strong>PKR {{ number_format($total) }}</strong> to <strong>0349-9050580</strong></li>
                                    <li>Enter your transaction ID and Easypaisa number below</li>
                                    <li>We will verify and confirm within 1 hour</li>
                                </ol>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:12px;">Transaction ID *</label>
                                    <input type="text" name="transaction_id" class="form-control form-control-sm"
                                        placeholder="e.g. EP123456789">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:12px;">Your Easypaisa Number *</label>
                                    <input type="text" name="account_number" class="form-control form-control-sm"
                                        placeholder="03XX-XXXXXXX">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bank Transfer --}}
                    <div class="payment-option border rounded-3 p-3" data-method="bank_transfer">
                        <div class="form-check">
                            <input class="form-check-input payment-radio" type="radio"
                                name="payment_method" value="bank_transfer" id="pay_bank">
                            <label class="form-check-label d-flex align-items-center gap-3 w-100" for="pay_bank" style="cursor:pointer;">
                                <div class="payment-icon rounded-2 d-flex align-items-center justify-content-center"
                                    style="width:48px;height:48px;background:#e3f2fd;font-size:22px;">
                                    🏦
                                </div>
                                <div>
                                    <div class="fw-bold" style="font-size:14px;">Bank Transfer</div>
                                    <div class="text-muted" style="font-size:12px;">Transfer to our bank account</div>
                                </div>
                                <span class="ms-auto badge bg-info text-dark">Manual</span>
                            </label>
                        </div>
                        <div class="payment-details mt-3 ps-4" style="display:none;">
                            <div class="bg-info bg-opacity-10 rounded-3 p-3 mb-3">
                                <div class="fw-bold mb-2" style="font-size:13px;"><i class="bi bi-bank me-1"></i>Bank Account Details</div>
                                <div class="row g-1" style="font-size:12px;">
                                    <div class="col-6 text-muted">Bank Name:</div>
                                    <div class="col-6 fw-bold">Meezan Bank</div>
                                    <div class="col-6 text-muted">Account Title:</div>
                                    <div class="col-6 fw-bold">ShopZone Pakistan</div>
                                    <div class="col-6 text-muted">Account Number:</div>
                                    <div class="col-6 fw-bold">0123-4567890-001</div>
                                    <div class="col-6 text-muted">IBAN:</div>
                                    <div class="col-6 fw-bold">PK12MEZN0001234567890</div>
                                    <div class="col-6 text-muted">Amount:</div>
                                    <div class="col-6 fw-bold text-danger">PKR {{ number_format($total) }}</div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:12px;">Transaction / Reference ID *</label>
                                    <input type="text" name="transaction_id" class="form-control form-control-sm"
                                        placeholder="e.g. TXN123456">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:12px;">Your Bank Account Number *</label>
                                    <input type="text" name="account_number" class="form-control form-control-sm"
                                        placeholder="Your account number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Order Summary --}}
        <div class="col-lg-5">
            <div class="bg-white rounded-3 border p-4 sticky-top" style="top:80px;">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">Order Summary</h6>

                {{-- Items --}}
                @foreach($items as $item)
                @php $price = $item->product->sale_price ?? $item->product->price; @endphp
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ $item->product->main_image ? asset('storage/'.$item->product->main_image) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=60' }}"
                        width="50" height="50" class="rounded border" style="object-fit:cover;">
                    <div class="flex-grow-1">
                        <div style="font-size:13px;font-weight:600;">{{ Str::limit($item->product->name, 30) }}</div>
                        <div class="text-muted" style="font-size:12px;">Qty: {{ $item->quantity }}</div>
                    </div>
                    <div class="fw-bold" style="font-size:13px;">
                        PKR {{ number_format($price * $item->quantity) }}
                    </div>
                </div>
                @endforeach

                <hr>

                <div class="d-flex justify-content-between mb-2" style="font-size:14px;">
                    <span class="text-muted">Subtotal</span>
                    <span>PKR {{ number_format($subtotal) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:14px;">
                    <span class="text-muted">Shipping</span>
                    <span class="{{ $shipping == 0 ? 'text-success fw-bold' : '' }}">
                        {{ $shipping == 0 ? 'FREE' : 'PKR ' . number_format($shipping) }}
                    </span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold fs-6">Total</span>
                    <span class="fw-bold fs-5 text-danger">PKR {{ number_format($total) }}</span>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg fw-bold">
                    <i class="bi bi-bag-check me-2"></i>Place Order
                </button>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="bi bi-shield-check text-success me-1"></i>
                        Your information is secure and encrypted
                    </small>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
@push('scripts')
    <script>
        // Payment method toggle
        $('.payment-radio').on('change', function() {
            const selected = $(this).val();

            // Reset all options
            $('.payment-option').removeClass('border-primary')
                                .addClass('border');
            $('.payment-details').slideUp(200);

            // Highlight selected
            $(this).closest('.payment-option')
                .removeClass('border')
                .addClass('border-primary');

            // Show details for non-COD
            if (selected !== 'cod') {
                $(this).closest('.payment-option')
                    .find('.payment-details')
                    .slideDown(200);
            }

            // Clear previous transaction inputs
            $('input[name="transaction_id"], input[name="account_number"]').val('');
        });

        // Highlight COD by default
        $('#pay_cod').closest('.payment-option')
                    .removeClass('border')
                    .addClass('border-primary');
    </script>
@endpush
@endsection