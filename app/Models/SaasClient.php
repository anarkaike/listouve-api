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

/**
 * Classe model do Eloquent que representa a entidade saas_client
 */
class SaasClient extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;

    protected $table = 'saas_clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email_personal',
        'email_pofessional',
        'phone_personal',
        'phone_pofessional',
        'observation',
        'status',
        'general_settings',
        'created_by',
        'updated_by',
        'updated_at',
        'updated_values',
        'deleted_at',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
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
