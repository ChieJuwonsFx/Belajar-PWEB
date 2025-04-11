<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    /** @use HasFactory<\Database\Factories\VillageFactory> */
    use HasFactory;
    protected $fillable = ['id_desa','nama_desa', 'district_id'];
    protected $primaryKey = 'id_desa';
    public $incrementing = false;
    protected $keyType = 'string';
    public function district()
    {
        return $this->belongsTo(District::class , 'district_id', 'id_kecamatan');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
