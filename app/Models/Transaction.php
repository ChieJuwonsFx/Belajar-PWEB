<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'id'; 
    public $incrementing = false; 

    public static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->id)) {
                $transaction->id = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    } 

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
