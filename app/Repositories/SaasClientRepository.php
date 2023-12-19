<?php
namespace App\Repositories;

use App\Contracts\Repositories\SaasClientRepositoryInterface;
use App\Models\SaasClient;


class SaasClientRepository implements SaasClientRepositoryInterface
{
    public function __construct(
        protected SaasClient $saasClient
    )
    {
    }

    public function listAll()
    {
        return $this->saasClient->filter()->get();
    }

    public function findById($id)
    {
        return $this->saasClient->find($id);
    }

    public function create(array $data)
    {
        return $this->saasClient->create($data);
    }

    public function update($id, array $data)
    {
        $saasClient = $this->saasClient->find($id);

        if ($saasClient) {
            $saasClient->update($data);
            return $saasClient;
        }

        return null;
    }

    public function delete($id, $deletedBy = null): bool
    {
        $saasClient = $this->saasClient->find($id);

        if ($saasClient) {
            $saasClient->delete();
            return true;
        }

        return false;
    }
}
