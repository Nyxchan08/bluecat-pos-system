<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'description',
        'sku',
        'price',
        'quantity',
        'category_id',
        'supplier_id',
        'brand',
        'cost_price',
        'discount',
        'status',
        'product_image',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->sku = self::generateUniqueSku();
        });
    }

    private static function generateUniqueSku()
    {
        do {
            $sku = 'SKU-' . strtoupper(Str::random(8));
        } while (self::where('sku', $sku)->exists());

        return $sku;
    }
}
