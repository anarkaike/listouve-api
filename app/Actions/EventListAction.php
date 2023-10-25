<?php

namespace App\Actions;

use App\Contracts\Actions\EventListActionInterface;
use App\Contracts\Repositories\EventListRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class EventListAction implements EventListActionInterface {

    public function __construct(
        private EventListRepositoryInterface $eventListRepository
    )
    {

    }

    public function listAll()
    {
        return $this->eventListRepository->listAll();
    }

    public function findById(int $id)
    {
        return $this->eventListRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        return $this->eventListRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $data['updated_by'] = Auth::id();
        return $this->eventListRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        $data['deleted_by'] = Auth::id();
        return $this->eventListRepository->delete($id);
    }
}
