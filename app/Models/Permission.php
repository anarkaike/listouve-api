<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends BaseModel
{
    protected $table = 'permissions';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:m',
        'updated_at' => 'datetime:d/m/Y H:m',
        'deleted_at' => 'datetime:d/m/Y H:m',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(related: User::class, table: 'user_permissions');
    }

    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(related: User::class, table: 'profiles_permissions');
    }
}
