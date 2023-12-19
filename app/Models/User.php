<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\{
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\SoftDeletes,
    Foundation\Auth\User as Authenticatable,
    Notifications\Notifiable,
};


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Filterable, Sortable;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_personal',
        'phone_professional',
        'url_photo',
        'status',
        'general_settings',
        'created_by',
        'updated_by',
        'updated_values',
        'deleted_at',
        'deleted_by',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime:d/m/Y H:m',
        'updated_at' => 'datetime:d/m/Y H:m',
        'deleted_at' => 'datetime:d/m/Y H:m',
    ];

    public function saasClient()
    {
        return $this->hasMany(related: SaasClient::class);
    }
}
