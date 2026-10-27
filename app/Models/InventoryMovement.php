<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model {
    protected $fillable = ['product_id','type','quantity','stock_before','stock_after','reason','order_id','user_id'];

    public function product() { 
        return $this->belongsTo(Product::class); 
    }

    public function order() { 
        return $this->belongsTo(Order::class); 
    }

    public function user() { 
        return $this->belongsTo(User::class); 
    }
}