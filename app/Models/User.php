<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'id'; 
    public $incrementing = false; 

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];
    // protected $with = ['user'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->id)) {
                $user->id = 'USR-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }
        });
    }


    public function village()
    {
        return $this->belongsTo(Village::class, 'desa_id', 'id_desa');
    }
    
    public function transactionsAsCustomer()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function transactionsAsAdmin()
    {
        return $this->hasMany(Transaction::class, 'admin_id');
    }
    public function stockAdjustment()
    {
        return $this->hasOne(Transaction::class);
    }
}
