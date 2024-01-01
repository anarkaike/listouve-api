<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes,
};
use Abbasudo\Purity\Traits\{
    Filterable,
    Sortable,
};
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($profile) {
            $profile->created_by = Auth::id();
        });
        static::updating(function ($profile) {
            $profile->updated_by = Auth::id();
        });
        static::deleting(function ($profile) {
            $profile->deleted_by = Auth::id();
        });
    }
}
