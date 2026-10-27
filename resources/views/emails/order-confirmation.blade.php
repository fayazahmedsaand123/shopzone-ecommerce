<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.1); }
        .header { background: linear-gradient(135deg, #1a1a2e, #0d6efd); padding: 30px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 28px; font-weight: 900; }
        .header h1 span { color: #ff6b35; }
        .header p { color: rgba(255,255,255,.8); margin: 8px 0 0; font-size: 14px; }
        .body { padding: 30px; }
        .success-badge { background: #e8f5e9; border: 1px solid #a5d6a7; border-radius: 10px; padding: 16px; text-align: center; margin-bottom: 24px; }
        .success-badge h3 { color: #2e7d32; margin: 0 0 4px; font-size: 18px; }
        .success-badge p { color: #388e3c; margin: 0; font-size: 13px; }
        .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #6c757d; }
        .info-value { font-weight: 600; color: #1a1a2e; }
        .section-title { font-size: 15px; font-weight: 700; color: #1a1a2e; margin: 24px 0 12px; border-left: 4px solid #0d6efd; padding-left: 12px; }
        .product-row { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f5f5f5; }
        .product-info { flex: 1; }
        .product-name { font-weight: 600; font-size: 14px; color: #1a1a2e; }
        .product-meta { font-size: 12px; color: #6c757d; }
        .product-total { font-weight: 700; color: #ff6b35; font-size: 14px; }
        .total-section { background: #f8f9fa; border-radius: 10px; padding: 16px; margin-top: 16px; }
        .total-row { display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 6px; }
        .total-row.grand { font-size: 16px; font-weight: 800; color: #ff6b35; border-top: 2px solid #e9ecef; padding-top: 10px; margin-top: 6px; }
        .footer { background: #1a1a2e; padding: 24px; text-align: center; }
        .footer p { color: rgba(255,255,255,.6); margin: 4px 0; font-size: 12px; }
        .btn { display: inline-block; background: #0d6efd; color: #fff !important; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14px; margin-top: 16px; }
    </style>
</head>
<body>
<div class="container">

    {{-- Header --}}
    <div class="header">
        <h1>Shop<span>Zone</span></h1>
        <p>Pakistan's Trusted Online Shopping Destination</p>
    </div>

    {{-- Body --}}
    <div class="body">

        {{-- Success --}}
        <div class="success-badge">
            <h3>✅ Order Placed Successfully!</h3>
            <p>Thank you {{ $order->shipping_name }}! Your order has been received.</p>
        </div>

        {{-- Order Info --}}
        <div class="section-title">Order Details</div>
        <div class="info-row">
            <span class="info-label">Order Number</span>
            <span class="info-value">#{{ $order->order_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Order Date</span>
            <span class="info-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment Method</span>
            <span class="info-value">{{ strtoupper($order->payment_method) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status</span>
            <span class="info-value" style="color:#ffc107;">Pending</span>
        </div>

        {{-- Items --}}
        <div class="section-title">Items Ordered</div>
        @foreach($order->items as $item)
        <div class="product-row">
            <div class="product-info">
                <div class="product-name">{{ $item->product_name }}</div>
                <div class="product-meta">SKU: {{ $item->product_sku }} | Qty: {{ $item->quantity }}</div>
            </div>
            <div class="product-total">PKR {{ number_format($item->subtotal) }}</div>
        </div>
        @endforeach

        {{-- Totals --}}
        <div class="total-section">
            <div class="total-row">
                <span style="color:#6c757d;">Subtotal</span>
                <span>PKR {{ number_format($order->subtotal) }}</span>
            </div>
            <div class="total-row">
                <span style="color:#6c757d;">Shipping</span>
                <span style="color:#198754;">{{ $order->shipping_amount == 0 ? 'FREE' : 'PKR ' . number_format($order->shipping_amount) }}</span>
            </div>
            <div class="total-row grand">
                <span>Total</span>
                <span>PKR {{ number_format($order->total) }}</span>
            </div>
        </div>

        {{-- Shipping --}}
        <div class="section-title">Shipping Address</div>
        <div class="info-row">
            <span class="info-label">Name</span>
            <span class="info-value">{{ $order->shipping_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Phone</span>
            <span class="info-value">{{ $order->shipping_phone }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Address</span>
            <span class="info-value">{{ $order->shipping_address }}, {{ $order->shipping_city }}</span>
        </div>

        <div style="text-align:center;margin-top:24px;">
            <p style="color:#6c757d;font-size:13px;">You can track your order status from your account.</p>
            <a href="{{ url('/account/orders/' . $order->id) }}" class="btn">
                Track My Order →
            </a>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>© {{ date('Y') }} ShopZone. All rights reserved.</p>
        <p>Hyderabad, Sindh, Pakistan</p>
        <p>support@shopzone.pk | 0349-9050580</p>
    </div>
</div>
</body>
</html>