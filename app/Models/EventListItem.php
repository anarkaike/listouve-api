<?php

namespace App\Models;

use App\Http\Controllers\Api\v1\EventsListsItemsController;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes,
};
use Illuminate\Support\Facades\Route;

/**
 * Classe model do Eloquent que representa a entidade event_list_item
 */
class EventListItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events_lists_items';
    protected $touches = ['events', 'events_lists',];

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

    public function saasClient()
    {
        return $this->belongsTo(related: SaasClient::class);
    }
}
