<?php

namespace App\Models;

class EventList extends BaseModel
{
    protected $table = 'events_lists';
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
    protected $hidden = [];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:m',
        'updated_at' => 'datetime:d/m/Y H:m',
        'deleted_at' => 'datetime:d/m/Y H:m',
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
