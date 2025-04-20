<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_hp',
        'role',
        'alamat',
        'status',
        'image',
        'desa_id',
    ];
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
