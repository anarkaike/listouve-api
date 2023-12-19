<?php
namespace App\Repositories;

use App\Contracts\Repositories\EventListRepositoryInterface;
use App\Models\EventList;


class EventListRepository implements EventListRepositoryInterface
{
    public function __construct(
        protected EventList $eventList
    )
    {
    }

    public function listAll()
    {
        return $this->eventList->filter()->get();
    }

    public function findById($id)
    {
        return $this->eventList->find($id);
    }

    public function create(array $data)
    {
        return $this->eventList->create($data);
    }

    public function update($id, array $data)
    {
        $eventList = $this->eventList->find($id);

        if ($eventList) {
            $eventList->update($data);
            return $eventList;
        }

        return null;
    }

    public function delete($id, $deletedBy = null): bool
    {
        $eventList = $this->eventList->find($id);

        if ($eventList) {
            $eventList->delete();
            return true;
        }

        return false;
    }
}
