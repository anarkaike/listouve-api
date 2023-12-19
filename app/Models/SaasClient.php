<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use App\Http\Controllers\Api\v1\SaasClientsController;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes,
};
use Illuminate\Support\Facades\Route;


class SaasClient extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;

    protected $table = 'saas_clients';
    protected $fillable = [
        'name',
        'email_personal',
        'email_professional',
        'phone_personal',
        'phone_professional',
        'observation',
        'status',
        'general_settings',
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

    public function events()
    {
        return $this->belongsToMany(related: Event::class);
    }

    public function eventsLists()
    {
        return $this->belongsToMany(related: EventList::class);
    }

    public function eventsListsItems()
    {
        return $this->belongsToMany(related: EventListItem::class);
    }

    public function users()
    {
        return $this->belongsToMany(related: User::class);
    }
}
