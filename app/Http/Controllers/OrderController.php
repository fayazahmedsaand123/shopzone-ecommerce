<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\InventoryMovement;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class OrderController extends Controller {

    // Show checkout page
    public function checkout() {
        $items = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = $items->sum(fn($i) =>
            ($i->product->sale_price ?? $i->product->price) * $i->quantity
        );

        $shipping = $subtotal >= 5000 ? 0 : 200;
        $total    = $subtotal + $shipping;

        return view('store.checkout', compact('items', 'subtotal', 'shipping', 'total'));
    }

    // Place order
    public function placeOrder(Request $request) {
        $request->validate([
            'full_name'      => 'required|string|max:100',
            'email' => 'required|email',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string',
            'city'           => 'required|string|max:100',
            'payment_method' => 'required|in:cod,jazzcash,easypaisa,bank_transfer',
            'transaction_id' => 'required_unless:payment_method,cod|nullable|string|max:100',
            'account_number' => 'required_unless:payment_method,cod|nullable|string|max:20',
            'order_notes'    => 'nullable|string|max:500',
        ]);

        $items = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Validate stock
        foreach ($items as $item) {
            if ($item->product->stock_quantity < $item->quantity) {
                return back()->with('error',
                    "Sorry, only {$item->product->stock_quantity} units of '{$item->product->name}' are available."
                );
            }
        }

        $subtotal = $items->sum(fn($i) =>
            ($i->product->sale_price ?? $i->product->price) * $i->quantity
        );

        $shipping = $subtotal >= 5000 ? 0 : 200;
        $total    = $subtotal + $shipping;

        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'order_number'    => 'ORD-' . strtoupper(Str::random(8)),
                'user_id'         => auth()->id(),
                'status'          => 'pending',
                'subtotal'        => $subtotal,
                'shipping_amount' => $shipping,
                'total'           => $total,
                'payment_method'  => $request->payment_method,
                'payment_status'  => $request->payment_method === 'cod' ? 'pending' : 'pending',
                'transaction_id'  => $request->transaction_id,
                'account_number'  => $request->account_number,
                'shipping_name'   => $request->full_name,
                'shipping_phone'  => $request->phone,
                'shipping_address'=> $request->address,
                'shipping_city'   => $request->city,
                'order_notes'     => $request->order_notes,
            ]);

            // Create order items + deduct stock
            foreach ($items as $item) {
                $price = $item->product->sale_price ?? $item->product->price;

                OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $item->product->id,
                    'product_name'=> $item->product->name,
                    'product_sku' => $item->product->sku,
                    'price'       => $price,
                    'quantity'    => $item->quantity,
                    'subtotal'    => $price * $item->quantity,
                ]);

                // Deduct stock
                $oldStock = $item->product->stock_quantity;
                $newStock = $oldStock - $item->quantity;

                $item->product->update(['stock_quantity' => $newStock]);

                InventoryMovement::create([
                    'product_id'   => $item->product->id,
                    'type'         => 'out',
                    'quantity'     => $item->quantity,
                    'stock_before' => $oldStock,
                    'stock_after'  => $newStock,
                    'reason'       => 'Order placed: ' . $order->order_number,
                    'order_id'     => $order->id,
                    'user_id'      => auth()->id(),
                ]);
            }

            // Payment record
            Payment::create([
                'order_id'       => $order->id,
                'payment_method' => $request->payment_method,
                'amount'         => $total,
                'status'         => 'pending',
                'notes'          => 'Cash on Delivery',
            ]);

            // Order status history
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status'   => 'pending',
                'comment'  => 'Order placed successfully.',
                'user_id'  => auth()->id(),
            ]);

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            try {
                $order->load('items', 'user');

                // Send confirmation to the customer only
                try {
                    Mail::to($request->email)->send(new OrderConfirmationMail($order));
                } catch (\Throwable $e) {
                    Log::error('Order confirmation email failed', [
                        'order' => $order->order_number,
                        'email' => $request->email,
                        'error' => $e->getMessage(),
                    ]);
                }
            } catch (\Throwable $e) {
                Log::error('Order email dispatch failed', [
                    'order' => $order->order_number,
                    'error' => $e->getMessage(),
                ]);
            }

            return redirect()->route('customer.orders.show', $order->id)
                ->with('success', 'Order placed successfully! Order #' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // Order history
    public function index() {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('store.orders.index', compact('orders'));
    }

    // Order details
    public function show(Order $order) {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product', 'statusHistories']);

        return view('store.orders.show', compact('order'));
    }
}