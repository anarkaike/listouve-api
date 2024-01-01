<?php

namespace App\Models;


class Profile extends BaseModel
{
    protected $table = 'profiles';
    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'updated_values',
        'deleted_at',
        'deleted_by',
    ];
    protected $hidden = [];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:m',
        'updated_at' => 'datetime:d/m/Y H:m',
        'deleted_at' => 'datetime:d/m/Y H:m',
    ];

    public function permissions()
    {
        return $this->belongsToMany(related: Permission::class, table: 'profile_permissions');
    }

    public function users()
    {
        return $this->belongsToMany(related: User::class, table: 'user_profiles');
    }

    public function addUser(User $user, $saasClientId): void
    {
        $this->users()->attach($user, ['saas_client_id' => $saasClientId]);
    }

    public function removeProfile(User $user, $saasClientId): void
    {
        $this->users()->detach($user, ['saas_client_id' => $saasClientId]);
    }

    public function hasProfile(Profile $profile, $saasClientId): bool
    {
        return $this->profiles()->where('id', $profile->id)->where('saas_client_id', $saasClientId)->exists();
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

}
