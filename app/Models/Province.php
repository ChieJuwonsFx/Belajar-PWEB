<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    /** @use HasFactory<\Database\Factories\ProvinceFactory> */
    use HasFactory;
    protected $fillable = ['id_provinsi','nama_provinsi'];
    protected $primaryKey = 'id_provinsi';
    public $incrementing = false;
    protected $keyType = 'string';
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
