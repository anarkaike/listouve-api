<?php
namespace App\Repositories;

use App\Contracts\Repositories\PermissionRepositoryInterface;
use App\Models\Permission;


class PermissionRepository implements PermissionRepositoryInterface
{
    public function __construct(
        protected Permission $permission
    ){
    }

    public function listAll()
    {
        return $this->permission->filter()->get();
    }

    public function findById($id)
    {
        return $this->permission->find($id);
    }

    public function create(array $data)
    {
        return $this->permission->create($data);
    }

    public function update($id, array $data)
    {
        $permission = $this->permission->find($id);

        if ($permission) {
            $permission->update($data);
            return $permission;
        }

        return null;
    }

    public function delete($id, $deletedBy = null): bool
    {
        $permission = $this->permission->find($id);

        $permission->deleted_by = $deletedBy;
        $permission->update();

        if ($permission) {
            $permission->delete();
            return true;
        }

        return false;
    }
}
