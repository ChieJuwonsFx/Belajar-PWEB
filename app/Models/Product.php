<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $casts = [
        'image' => 'array',
    ];

    protected $fillable=[
        'name',
        'deskripsi',
        'harga_jual',
        'stok' ,
        'stok_minimum' ,
        'image' ,
        'is_available',
        'is_active',
        'is_stock_real',
        'is_modal_real' ,
        'estimasi_modal',
        'category_id',
        'unit_id',
    ];
    

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
