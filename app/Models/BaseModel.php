<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Casts\Attribute, Factories\HasFactory, Model, SoftDeletes};
use Abbasudo\Purity\Traits\{
    Filterable,
    Sortable,
};
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;

//    protected $appends = ['created_by_user', 'updated_by_user', 'deleted_by_user'];

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

    protected function createdAt (): Attribute {
        return Attribute::make(
            get: fn (string|null $value) => !$value?null:\Carbon\Carbon::parse(str_replace('/', '-', $value))->format('d/m/Y H:i')
        );
    }

    protected function updatedAt (): Attribute {
        return Attribute::make(
            get: fn (string|null $value) => !$value?null:\Carbon\Carbon::parse(str_replace('/', '-', $value))->format('d/m/Y H:i')
        );
    }

    protected function deletedAt (): Attribute {
        return Attribute::make(
            get: fn (string|null $value) => !$value?null:\Carbon\Carbon::parse(str_replace('/', '-', $value))->format('d/m/Y H:i')
        );
    }

//    // Definindo a relação belongsTo com o modelo User
//    public function createdByUser()
//    {
//        return $this->belongsTo(User::class, 'created_by', 'id');
//    }
//
//    public function getCreatedByUserAttribute()
//    {
//        $model = $this->createdByUser()->select(['id', 'name'])->get()->first();
//        return $model ? $model->toArray() : [];
//    }
//
//    // Definindo a relação belongsTo com o modelo User
//    public function updatedByUser()
//    {
//        return $this->belongsTo(User::class, 'updated_by', 'id');
//    }
//
//    public function getUpdatedByUserAttribute()
//    {
//        $model = $this->updatedByUser()->select(['id', 'name'])->get()->first();
//        return $model ? $model->toArray() : [];
//    }
//
//    // Definindo a relação belongsTo com o modelo User
//    public function deletedByUser()
//    {
//        return $this->belongsTo(User::class, 'deleted_by', 'id');
//    }
//
//    public function getDeletedByUserAttribute()
//    {
//        $model = $this->deletedByUser()->select(['id', 'name'])->get()->first();
//        return $model ? $model->toArray() : [];
//    }
}
