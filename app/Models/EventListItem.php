<?php

namespace App\Models;


class EventListItem extends BaseModel
{
    protected $table = 'events_lists_items';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_id',
        'event_list_id',
        'payment_status',
        'saas_client_id',
        'created_by',
        'updated_by',
        'updated_values',
        'deleted_at',
        'deleted_by',
    ];
    protected $hidden = [];
    protected $casts = [];

    public function saasClient()
    {
        return $this->belongsTo(related: SaasClient::class);
    }
}
