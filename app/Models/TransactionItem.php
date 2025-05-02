<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionItem extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionItemFactory> */
    use HasFactory;

    protected $primaryKey = 'id'; 
    public $incrementing = false; 

    public static function boot()
    {
        parent::boot();

        static::creating(function ($transaction_item) {
            if (empty($transaction_item->id)) {
                $transaction_item->id = 'TRI-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }
        });
    }

    public function transaction_item()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
