<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
};

class SaasClient extends Model
{
    use HasFactory;

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

    public function events()
    {
        return $this->belongsToMany(related: Event::class, table: 'saas_client_event_rel');
    }

    public function eventsLists()
    {
        return $this->belongsToMany(related: EventList::class, table: 'saas_client_event_list_rel');
    }

    public function eventsListsItems()
    {
        return $this->belongsToMany(related: EventListItem::class, table: 'saas_client_event_list_item_rel');
    }
}
