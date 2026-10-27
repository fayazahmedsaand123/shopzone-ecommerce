@extends('layouts.app')
@section('title', 'FAQ — ShopZone')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Frequently Asked Questions</h2>
        <p class="text-muted">Find answers to the most common questions about ShopZone</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="accordion" id="faqAccordion">
                @php
                $faqs = [
                    ['How do I place an order?', 'Browse products, add items to your cart, proceed to checkout, fill in your shipping details and click Place Order.'],
                    ['What payment methods are accepted?', 'Currently we accept Cash on Delivery (COD) across Pakistan. Online payment options coming soon.'],
                    ['How long does delivery take?', 'Standard delivery takes 2-5 business days depending on your location. Major cities are usually faster.'],
                    ['Can I return a product?', 'Yes! We offer a 7-day return policy. Contact our support team and we will arrange a pickup.'],
                    ['How do I track my order?', 'Login to your account, go to My Orders, and click on any order to see its current status and timeline.'],
                    ['Is my payment information secure?', 'Yes, all transactions are secured with SSL encryption. We never store your payment details.'],
                    ['Can I cancel my order?', 'You can cancel your order before it is shipped. Go to My Orders and contact our support team.'],
                    ['Do you ship to all cities in Pakistan?', 'Yes, we deliver to all major cities and towns across Pakistan including remote areas.'],
                ];
                @endphp

                @foreach($faqs as $i => $faq)
                <div class="accordion-item border mb-2 rounded-3 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button {{ $i > 0 ? 'collapsed' : '' }} fw-semibold"
                            type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq{{ $i }}">
                            <i class="bi bi-question-circle text-primary me-2"></i>
                            {{ $faq[0] }}
                        </button>
                    </h2>
                    <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                         data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted" style="font-size:14px;">
                            {{ $faq[1] }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5 bg-white rounded-3 border p-4">
                <h5 class="fw-bold">Still have questions?</h5>
                <p class="text-muted">Our support team is here to help you</p>
                <a href="{{ route('contact') }}" class="btn btn-primary px-5">
                    <i class="bi bi-chat me-2"></i>Contact Us
                </a>
            </div>
        </div>
    </div>
</div>
@endsection