<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use HasFactory;

    protected $primaryKey = 'id'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($stock) {
            if (empty($stock->id)) {
                $stock->id = 'STK-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
