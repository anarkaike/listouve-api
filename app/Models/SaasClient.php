<?php

namespace App\Models;


class SaasClient extends BaseModel
{
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
