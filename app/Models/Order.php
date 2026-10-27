<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model {

    use HasFactory;

    protected $fillable = [
        'order_number','user_id','status','subtotal','discount_amount',
        'shipping_amount','tax_amount','total','coupon_code','payment_method',
        'payment_status','shipping_name','shipping_phone','shipping_address',
        'shipping_city','shipping_country','order_notes',
        'transaction_id', 'account_number',
    ];

    public function user() { 
        return $this->belongsTo(User::class); 
    }

    public function items() { 
        return $this->hasMany(OrderItem::class); 
    }

    public function payment() { 
        return $this->hasOne(Payment::class); 
    }

    public function statusHistories() { 
        return $this->hasMany(OrderStatusHistory::class); 
    }

    public function couponUsage() { 
        return $this->hasOne(CouponUsage::class); 
    }
}