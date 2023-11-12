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
        private UserRepositoryInterface $repository
    )
    {

    }

    public function listAll()
    {
        return $this->repository->listAll();
    }

    public function findById(int $id): User|null
    {
        return $this->repository->findById($id);
    }

    public function create(array $data): User
    {
        $data['created_by'] = $data['created_by'] ?? Auth::id();
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): User
    {
        $data['updated_by'] = $data['updated_by'] ?? Auth::id();
        return $this->repository->update($id, $data);
    }

    public function delete(int $id, int $deletedBy = null): bool
    {
        return $this->repository->delete(id: $id, deletedBy: $deletedBy ?? Auth::id());
    }
}
