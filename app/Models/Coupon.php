<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code','type','value','min_order_amount','max_discount','usage_limit','per_user_limit','used_count','starts_at','expires_at','status'];
    protected $casts = ['starts_at' => 'date', 'expires_at' => 'date'];

    public function usages() { return $this->hasMany(CouponUsage::class); }

    public function isValid()
    {
        if ($this->status !== 'active') return false;
        if ($this->starts_at && now()->lt($this->starts_at)) return false;
        if ($this->expires_at && now()->gt($this->expires_at)) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        return true;
    }
}