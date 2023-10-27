<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\{
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\SoftDeletes,
    Foundation\Auth\User as Authenticatable,
    Notifications\Notifiable,
};

/**
 * Classe model do Eloquent que representa a entidade saas
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_personal',
        'phone_professional',
        'url_photo',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function saasClient()
    {
        return $this->hasMany(related: SaasClient::class);
    }
}
