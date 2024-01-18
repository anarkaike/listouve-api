<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected function startsAt (): Attribute {
        return Attribute::make(
            get: fn (string|null $value) => !$value?null:\Carbon\Carbon::parse(str_replace('/', '-', $value))->format('d/m/Y H:i')
        );
    }

    protected function endsAt (): Attribute {
        return Attribute::make(
            get: fn (string $value) => \Carbon\Carbon::parse(str_replace('/', '-', $value))->format('d/m/Y H:i')
        );
    }

    public function eventsLists()
    {
        return $this->hasMany(related: EventList::class);
    }

    public function saasClient()
    {
        return $this->belongsTo(related: SaasClient::class);
    }
}
