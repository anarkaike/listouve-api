<?php
namespace App\Repositories;

use App\Contracts\Repositories\ProfileRepositoryInterface;
use App\Models\Profile;


class ProfileRepository implements ProfileRepositoryInterface
{
    public function __construct(
        protected Profile $profile
    ){
    }

    public function listAll()
    {
        return $this->profile->filter()->get();
    }

    public function findById($id)
    {
        return $this->profile->find($id);
    }

    public function create(array $data)
    {
        return $this->profile->create($data);
    }

    public function update($id, array $data)
    {
        $profile = $this->profile->find($id);

        if ($profile) {
            $profile->update($data);
            return $profile;
        }

        return null;
    }

    public function delete($id, $deletedBy = null): bool
    {
        $profile = $this->profile->find($id);

        $profile->deleted_by = $deletedBy;
        $profile->update();

        if ($profile) {
            $profile->delete();
            return true;
        }

        return false;
    }
}
