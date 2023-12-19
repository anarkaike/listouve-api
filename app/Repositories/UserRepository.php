<?php
namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;


class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $user
    ){
    }

    public function listAll()
    {
        return $this->user->filter()->get();
    }

    public function findById($id)
    {
        return $this->user->find($id);
    }

    public function create(array $data)
    {
        return $this->user->create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->user->find($id);

        if ($user) {
            $user->update($data);
            return $user;
        }

        return null;
    }

    public function delete($id, $deletedBy = null): bool
    {
        $user = $this->user->find($id);

        $user->deleted_by = $deletedBy;
        $user->update();

        if ($user) {
            $user->delete();
            return true;
        }

        return false;
    }
}
