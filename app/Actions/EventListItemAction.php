<?php

namespace App\Actions;

use App\Contracts\Actions\EventListItemActionInterface;
use App\Contracts\Repositories\EventListItemRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class EventListItemAction implements EventListItemActionInterface {

    public function __construct(
        private EventListItemRepositoryInterface $repository
    )
    {

    }

    public function listAll()
    {
        return $this->repository->listAll();
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data)
    {
        $data['created_by'] = $data['created_by'] ?? Auth::id();
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        $data['updated_by'] = $data['updated_by'] ?? Auth::id();
        return $this->repository->update($id, $data);
    }

    public function delete(int $id, int $deletedBy = null): bool
    {
        return $this->repository->delete(id: $id, deletedBy: $deletedBy ?? Auth::id());
    }
}
