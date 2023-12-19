<?php
namespace App\Repositories;

use App\Contracts\Repositories\EventListItemRepositoryInterface;
use App\Models\EventListItem;

class EventListItemRepository implements EventListItemRepositoryInterface
{

    public function __construct(
        protected EventListItem $eventListItem
    )
    {
    }

    public function listAll()
    {
        return $this->eventListItem->filter()->get();
    }

    public function findById($id)
    {
        return $this->eventListItem->find($id);
    }

    public function create(array $data)
    {
        return $this->eventListItem->create($data);
    }

    public function update($id, array $data)
    {
        $eventListItem = $this->eventListItem->find($id);

        if ($eventListItem) {
            $eventListItem->update($data);
            return $eventListItem;
        }

        return null;
    }

    public function delete($id, $deletedBy = null): bool
    {
        $eventListItem = $this->eventListItem->find($id);

        if ($eventListItem) {
            $eventListItem->delete();
            return true;
        }

        return false;
    }
}
