@extends('layouts.app')
@section('title', 'FAQ — ShopZone')

@section('content')
<div class="container">
    <div class="page-head text-center">
        <span class="eyebrow"><i class="bi bi-question-circle"></i>Help centre</span>
        <h1 class="page-title mt-2">Frequently asked questions</h1>
        <p class="text-muted mb-0">Everything you need to know about ordering from ShopZone.</p>
    </div>

    <div class="row justify-content-center pb-5">
        <div class="col-lg-8">
            <div class="accordion" id="faqAccordion">
                @php
                $faqs = [
                    ['How do I place an order?', 'Browse products, add items to your cart, proceed to checkout, fill in your shipping details and click Place Order.'],
                    ['What payment methods are accepted?', 'We accept Cash on Delivery, JazzCash, Easypaisa and Bank Transfer across Pakistan.'],
                    ['How long does delivery take?', 'Standard delivery takes 2–5 business days depending on your location. Major cities are usually faster.'],
                    ['Can I return a product?', 'Yes — we offer a 7-day return policy. Contact our support team and we will arrange a pickup.'],
                    ['How do I track my order?', 'Log in, go to My Orders, and open any order to see its current status and timeline.'],
                    ['Is my payment information secure?', 'Yes, all traffic is encrypted with SSL. We never store your card or wallet credentials.'],
                    ['Can I cancel my order?', 'You can cancel before your order is shipped. Go to My Orders and contact support.'],
                    ['Do you ship to all cities in Pakistan?', 'Yes, we deliver to all major cities and towns across Pakistan, including remote areas.'],
                ];
                @endphp

                @foreach($faqs as $i => $faq)
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header">
                        <button class="accordion-button {{ $i > 0 ? 'collapsed' : '' }} fw-semibold" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}">
                            <i class="bi bi-question-circle me-2 text-primary"></i>{{ $faq[0] }}
                        </button>
                    </h2>
                    <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">{{ $faq[1] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="panel panel-pad text-center mt-4">
                <h2 class="h5 fw-bold">Still have questions?</h2>
                <p class="text-muted small">Our support team is here to help you six days a week.</p>
                <a href="{{ route('contact') }}" class="btn btn-primary px-4">
                    <i class="bi bi-chat me-2"></i>Contact Us
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
