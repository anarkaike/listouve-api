<?php

namespace App\Models;


use Illuminate\Notifications\Notifiable;

class SaasClient extends BaseModel
{
    use Notifiable;
    protected $table = 'saas_clients';
    protected $fillable = [
        'company_name',
        'contact_name',
        'email',
        'phone',
        'url_foto',
        'observation',
        'status',
        'business_sector',
        'general_settings',
        'email_confirmed_at',
        'code_email_validation',
        'created_by',
        'updated_by',
        'updated_values',
        'deleted_at',
        'deleted_by',
    ];
    protected $hidden = [];
    protected $casts = [];

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


    // RELACIONAMENTO MN COM USERS
    public function users()
    {
        return $this->belongsToMany(related: User::class, table: 'saas_client_users');
    }

    public function addUser(User $user): void
    {
        if (!$this->hasUser($user)) {
            $this->users()->attach($user->id);
        }
    }

    public function removeUser(User $user): void
    {
        if ($this->hasUser($user)) {
            $this->users()->detach($user->id);
        }
    }

    public function hasUser(User $user): bool
    {
        return $this->users()->where('users.id', $user->id)->exists();
    }
}
