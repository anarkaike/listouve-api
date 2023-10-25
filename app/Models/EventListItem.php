<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
};

class EventListItem extends Model
{
    use HasFactory;

    protected $table = 'events_lists_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    public function saasClients()
    {
        return $this->belongsToMany(related: SaasClient::class, table: 'saas_client_event_item_list_rel');
    }
}
