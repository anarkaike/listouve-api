<?php

namespace App\Contracts\Repositories;

interface RepositoryInterface
{
    public function listAll();

    public function findById($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id, $deletedBy = null): bool;
}
