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
    

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
}
