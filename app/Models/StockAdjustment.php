<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockAdjustment extends Model
{
    /** @use HasFactory<\Database\Factories\StockAdjustmentFactory> */
    use HasFactory;

    protected $primaryKey = 'id'; 
    public $incrementing = false;
     
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($stock_adjusment) {
            if (empty($stock_adjusment->id)) {
                $stock_adjusment->id = 'ADJ-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }
        });
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
