<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Relations\BelongsToMany,
    Database\Eloquent\SoftDeletes,
    Foundation\Auth\User as Authenticatable,
    Notifications\Notifiable,
    Support\Facades\Auth};
use Abbasudo\Purity\Traits\{
    Filterable,
    Sortable,
};


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Filterable, Sortable;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
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
        'email_verified_at' => 'datetime:d/m/Y H:m',
        'password' => 'hashed',
        'created_at' => 'datetime:d/m/Y H:m',
        'updated_at' => 'datetime:d/m/Y H:m',
        'deleted_at' => 'datetime:d/m/Y H:m',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
        static::deleting(function ($model) {
            $model->deleted_by = Auth::id();
        });
    }

    // RELACIONAMENTO COM CLIENTE SAAS
    public function saasClients()
    {
        return $this->belongsToMany(related: SaasClient::class, table: 'saas_client_users');
    }

    public function addSaasClient(SaasClient $saasClient): void
    {
        $this->saasClients()->attach($saasClient->id);
    }

    public function removeSaasClient(SaasClient $saasClient): void
    {
        $this->saasClients()->detach($saasClient->id);
    }

    public function hasSaasClient(SaasClient $saasClient): bool
    {
        return $this->saasClients()->where('id', $saasClient->id)->exists();
    }

    // RELACIONAMENTO COM PERMISSIONS
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(related: Permission::class, table: 'user_permissions');
    }

    public function assignPermission(string $permission): void
    {
        if (!$this->hasPermission($permission)) {
            $this->permissions()->attach(Permission::where('name', $permission)->first());
        }
    }

    public function addPermission(string|Permission $permission)
    {
        if (is_object($permission)) {
            $permission = $permission->name;
        }
        $this->assignPermission($permission);
    }

    public function revokePermission(string $permission): void
    {
        if ($this->hasPermission($permission)) {
            $this->permissions()->detach(Permission::where('name', $permission)->first());
        }
    }

    public function removePermission(string|Permission $permission)
    {
        if (is_object($permission)) {
            $permission = $permission->name;
        }
        $this->revokePermission($permission);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    // RELACIONAMENTO COM PROFILES
    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(related: Profile::class, table: 'user_profiles');
    }

    public function addProfile(Profile $profile, $saasClientId): void
    {
        $this->profiles()->attach($profile->id, ['saas_client_id' => $saasClientId]);
    }

    public function removeProfile(Profile $profile, $saasClientId): void
    {
        $this->profiles()->detach($profile->id, ['saas_client_id' => $saasClientId]);
    }

    public function hasProfile(Profile $profile, $saasClientId): bool
    {
        return $this->profiles()->where('id', $profile->id)->where('saas_client_id', $saasClientId)->exists();
    }
}
