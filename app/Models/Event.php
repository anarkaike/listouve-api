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

class Event extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;

    protected $table = 'events';
    protected $fillable = [
        'name',
        'description',
        'url_photo',
        'saas_client_id',
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

    public function eventsLists()
    {
        return $this->hasMany(related: EventList::class);
    }

    public function saasClient()
    {
        return $this->belongsTo(related: SaasClient::class);
    }
}
