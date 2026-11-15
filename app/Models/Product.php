<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {
    
    use HasFactory;

    private const PLACEHOLDER_IMAGE = 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80';

    protected $fillable = [
        'name','slug','sku','description','short_description',
        'category_id','brand_id','price','sale_price','stock_quantity',
        'main_image','status','is_featured','weight','dimensions','views_count'
    ];

    protected $casts = ['is_featured' => 'boolean', 'price' => 'decimal:2', 'sale_price' => 'decimal:2'];

    public function category() { 
        return $this->belongsTo(Category::class); 
    }

    public function brand() { 
        return $this->belongsTo(Brand::class); 
    }

    public function images() { 
        return $this->hasMany(ProductImage::class)->orderBy('sort_order'); 
    }

    public function reviews() { 
        return $this->hasMany(Review::class); 
    }

    public function wishlists() { 
        return $this->hasMany(Wishlist::class); 
    }

    public function inventoryMovements() { 
        return $this->hasMany(InventoryMovement::class); 
    }

    public function orderItems() { 
        return $this->hasMany(OrderItem::class); 
    }

    // Get current selling price
    public function getCurrentPriceAttribute() {
        return $this->sale_price ?? $this->price;
    }

    // Check if product is on sale
    public function getIsOnSaleAttribute() {
        return !is_null($this->sale_price) && $this->sale_price < $this->price;
    }

    // Average rating
    public function getAverageRatingAttribute() {
        return $this->reviews()->where('status','approved')->avg('rating') ?? 0;
    }

    // Check if in stock
    public function getInStockAttribute() {
        return $this->stock_quantity > 0;
    }

    // Resolve local storage paths and remote URLs to a usable image URL
    public function getImageUrlAttribute(): string {
        $path = $this->main_image;

        if (!$path) {
            return self::PLACEHOLDER_IMAGE;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return is_file(public_path('storage/' . $path))
            ? asset('storage/' . $path)
            : self::PLACEHOLDER_IMAGE;
    }
}