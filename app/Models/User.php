<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Relations\BelongsTo,
    Database\Eloquent\Relations\BelongsToMany,
    Database\Eloquent\Relations\HasMany,
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
        'password' => 'hashed',
    ];
    protected $appends = [
        'profile_ids',
        'profile_id',
        'saas_client_ids',
        'saas_client_id',
        'profiles',
        'created_by_user',
        'updated_by_user',
        'deleted_by_user'
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
        if (!$this->hasSaasClient($saasClient)) {
            $this->saasClients()->attach($saasClient->id);
        }
    }

    public function removeSaasClient(SaasClient $saasClient): void
    {
        if ($this->hasSaasClient($saasClient)) {
            $this->saasClients()->detach($saasClient->id);
        }
    }

    public function hasSaasClient(SaasClient $saasClient): bool
    {
        return $this->saasClients()->where('saas_clients.id', $saasClient->id)->exists();
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

    public function addProfile(Profile $profile, $saasClientId = null): void
    {
        if (!$this->hasProfile($profile, $saasClientId)) {
            $this->profiles()->attach($profile->id, ['saas_client_id' => $saasClientId]);
        }
    }

    public function removeProfile(Profile $profile, $saasClientId): void
    {
        if ($this->hasProfile($profile, $saasClientId)) {
            $this->profiles()->detach($profile->id, ['saas_client_id' => $saasClientId]);
        }
    }

    public function hasProfile(Profile $profile, $saasClientId): bool
    {
        return $this->profiles()->where('profiles.id', $profile->id)->where('saas_client_id', $saasClientId)->exists();
    }

    public function getProfileIdsAttribute()
    {
        return $this->profiles()->pluck('profiles.id')->toArray();
    }

    public function getProfileIdAttribute()
    {
        $arr = $this->profiles()->pluck('profiles.id')->toArray();
        return count($arr) > 1 ? $arr[0] : $arr;
    }

    public function getProfilesAttribute()
    {
        return $this->profiles()->get(['profiles.name', 'profiles.id'])->map(function ($profile) {
            return $profile->only(['id', 'name']);
        })->toArray();
    }

    public function getSaasClientIdsAttribute()
    {
        return $this->saasClients()->pluck('saas_clients.id')->toArray();
    }

    public function getSaasClientIdAttribute()
    {
        $arr = $this->saasClients()->pluck('saas_clients.id')->toArray();
        return count($arr) > 0 ? $arr[0]: $arr;
    }


    // Definindo a relação belongsTo com o modelo User
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function getCreatedByUserAttribute()
    {
        $model = $this->createdByUser()->select(['id', 'name'])->get()->first();
        return $model ? $model->toArray() : [];
    }

    // Definindo a relação belongsTo com o modelo User
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function getUpdatedByUserAttribute()
    {
        $model = $this->updatedByUser()->select(['id', 'name'])->get()->first();
        return $model ? $model->toArray() : [];
    }

    // Definindo a relação belongsTo com o modelo User
    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

    public function getDeletedByUserAttribute()
    {
        $model = $this->deletedByUser()->select(['id', 'name'])->get()->first();
        return $model ? $model->toArray() : [];
    }

//    public function scopeWithIdsFk()
//    {
//        return $this->select(
//            'users.*',
//            DB::raw('(SELECT GROUP_CONCAT(profiles.id) FROM profiles INNER JOIN user_profile ON profiles.id = user_profile.profile_id WHERE user_profile.user_id = users.id) as profile_ids'),
//            DB::raw('(SELECT GROUP_CONCAT(saas_clients.id) FROM saas_clients INNER JOIN user_saas_client ON saas_clients.id = user_saas_client.saas_client_id WHERE user_saas_client.user_id = users.id) as saas_client_ids')
//        );
//    }
}
