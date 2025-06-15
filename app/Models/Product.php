<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $primaryKey = 'id'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $casts = [
        'image' => 'array',
    ];

    protected $fillable = [
        'id',
        'barcode',
        'name',
        'slug',
        'deskripsi',
        'harga_jual',
        'stok_minimum',
        'stok',
        'image',
        'is_available',
        'is_active',
        'is_stock_real',
        'is_modal_real',
        'estimasi_modal',
        'category_id',
        'unit_id'
    ];
    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->id)) {
                $product->id = 'PRD-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
