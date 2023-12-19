<?php

namespace App\Contracts\Actions;

interface ActionInterface
{
    public function listAll();

    public function findById(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id, int $deletedBy = null);
}
