<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    /** @use HasFactory<\Database\Factories\DistrictFactory> */
    use HasFactory;
    protected $fillable = ['id_kecamatan', 'nama_kecamatan', 'city_id'];
    protected $primaryKey = 'id_kecamatan';
    public $incrementing = false;
    protected $keyType = 'string';
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id_kabupaten');
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
