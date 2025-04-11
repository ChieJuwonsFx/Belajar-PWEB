<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory;
    protected $fillable = ['id_kabupaten', 'nama_kabupaten', 'province_id'];
    protected $primaryKey = 'id_kabupaten';
    public $incrementing = false;
    protected $keyType = 'string';
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id_provinsi');
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
