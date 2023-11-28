<?php

namespace App\Http\Resources;

use Illuminate\Http\{
    Request,
    Resources\Json\JsonResource,
};
use App\Models\User;

/**
 * Classe para padronizar o retorno de dados nos en points da entidade User
 */
class UserResource extends JsonResource
{
    protected $user;

    public function __construct($resource, User $user)
    {
        parent::__construct($resource);
        $this->user = $user;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'created_at' => $this->user->created_at,
            'updated_at' => $this->user->updated_at,
            'phone_personal' => $this->user->phone_personal,
            'phone_professional' => $this->user->phone_professional,
            'created_by' => $this->user->created_by,
            'updated_by' => $this->user->updated_by,
            'deleted_by' => $this->user->deleted_by,
            'deleted_at' => $this->user->deleted_at,
        ];
    }
}
