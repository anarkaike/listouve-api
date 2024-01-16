<?php

namespace App\Models;


class Profile extends BaseModel
{
    protected $table = 'profiles';
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
        'updated_values',
        'deleted_at',
        'deleted_by',
    ];
    protected $hidden = [];
    protected $casts = [];
//    protected $appends = ['permissions'];

    // RELACIONAMENTO COM USUARIOS
    public function users()
    {
        return $this->belongsToMany(related: User::class, table: 'user_profiles');
    }

    public function addUser(User $user, $saasClientId): void
    {
        if (!$this->hasUser($user, $saasClientId)) {
            $this->users()->attach($user, ['saas_client_id' => $saasClientId]);
        }
    }

    public function removeUser(User $user, $saasClientId): void
    {
        if ($this->hasUser($user, $saasClientId)) {
            $this->users()->deattach($user, ['saas_client_id' => $saasClientId]);
        }
    }

    public function hasUser(User $user, $saasClientId): bool
    {
        return $this->users()->where('users.id', $user->id)->where('saas_client_id', $saasClientId)->exists();
    }

    // RELACIONAMENTO COM PERMISSOES
    public function permissions()
    {
        return $this->belongsToMany(related: Permission::class, table: 'profile_permissions');
    }

    public function assignPermission(string $permission): void
    {
        if (!$this->hasPermission($permission)) {
            $this->permissions()->attach(Permission::where('name', $permission)->first());
        }
    }

    public function revokePermission(string $permission): void
    {
        if ($this->hasPermission($permission)) {
            $this->permissions()->detach(Permission::where('name', $permission)->first());
        }
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    public function getPermissionsAttribute()
    {
        return $this->permissions()->get(['permissions.name', 'permissions.id'])->map(function ($permission) {
            return $permission->only(['id', 'name']);
        })->toArray();
    }

}
