<?php

namespace App\Actions;

use App\Contracts\Actions\UserActionInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $data['deleted_by'] = Auth::id();
        return $this->userRepository->delete($id);
    }
}
