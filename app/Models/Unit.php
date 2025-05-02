<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    /** @use HasFactory<\Database\Factories\UnitFactory> */
    use HasFactory;

    protected $primaryKey = 'id'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $guarded = [];
    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($unit) {
            if (empty($unit->id)) {
                $unit->id = 'UNT-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }
        });
    }
    
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
