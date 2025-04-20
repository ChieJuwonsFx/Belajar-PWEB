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
        'stock_id',
        'created_by'
        
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
