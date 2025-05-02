<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $primaryKey = 'id'; 
    public $incrementing = false; 

    public static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->id)) {
                $payment->id = 'PAY-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }
        });
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
