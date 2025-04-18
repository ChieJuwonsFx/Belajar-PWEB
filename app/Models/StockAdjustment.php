<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    /** @use HasFactory<\Database\Factories\StockAdjustmentFactory> */
    use HasFactory;

    protected $fillable=[
        'quantity',
        'alasan',
        'note',
        
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
