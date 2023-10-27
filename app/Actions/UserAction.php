<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Contracts\{
    Actions\UserActionInterface,
    Repositories\UserRepositoryInterface,
};

/**
 * Classe Action para camada de negócio para entidade Usuário (users/User)
 */
class UserAction implements UserActionInterface {

    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {

    }

    public function listAll()
    {
        return $this->userRepository->listAll();
    }

    public function findById(int $id): User|null
    {
        return $this->userRepository->findById($id);
    }

    public function create(array $data): User
    {
        $data['created_by'] = Auth::id();
        return $this->userRepository->create($data);
    }

    public function update(int $id, array $data): User
    {
        $data['updated_by'] = Auth::id();
        return $this->userRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->userRepository->delete(id: $id, deletedBy: Auth::id());
    }
}
