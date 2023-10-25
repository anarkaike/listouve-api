<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
};

class EventList extends Model
{
    use HasFactory;

    protected $table = 'events_lists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'url_photo',
        'event_id',
        'saas_client_id',
        'created_by',
        'updated_by',
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
    ];

    public function eventsListsItems()
    {
        return $this->hasMany(related: EventListItem::class);
    }

    public function saasClients()
    {
        return $this->belongsToMany(related: SaasClient::class, table: 'saas_client_event_list_rel');
    }
}
