<?php

namespace App\Models;

use App\Http\Controllers\Api\v1\EventsListsController;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes,
};
use Illuminate\Support\Facades\Route;

/**
 * Classe model do Eloquent que representa a entidade event_list
 */
class EventList extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events_lists';
    protected $touches = ['events',];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_id',
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
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function eventsListsItems()
    {
        return $this->hasMany(related: EventListItem::class);
    }

    public function event()
    {
        return $this->belongsToMany(related: EventListItem::class);
    }

    public function saasClient()
    {
        return $this->belongsTo(related: SaasClient::class);
    }
}
