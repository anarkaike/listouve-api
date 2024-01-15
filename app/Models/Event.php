<?php

namespace App\Models;

class Event extends BaseModel
{
    protected $table = 'events';
    protected $fillable = [
        'name',
        'starts_at',
        'ends_at',
        'duration_in_hours',
        'name',
        'description',
        'url_banner',
        'address',
        'city',
        'state',
        'contact_info',
        'attractions_info',
        'payment_info',
        'restrictions_info',
        'ticket_info',
        'social_networks',
        'saas_client_id',
        'created_by',
        'updated_by',
        'updated_values',
        'deleted_at',
        'deleted_by',
    ];
    protected $hidden = [];
    protected $casts = [];

    public function eventsLists()
    {
        return $this->hasMany(related: EventList::class);
    }

    public function saasClient()
    {
        return $this->belongsTo(related: SaasClient::class);
    }
}
