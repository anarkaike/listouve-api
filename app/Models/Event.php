<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes,
};

/**
 * Classe model do Eloquent que representa a entidade event
 */
class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
    ];

    public function eventsLists()
    {
        return $this->hasMany(related: EventList::class);
    }

    public function saasClient()
    {
        return $this->belongsTo(related: SaasClient::class);
    }
}
