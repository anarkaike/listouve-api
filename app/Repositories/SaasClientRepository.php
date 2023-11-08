<?php
namespace App\Repositories;

use App\Contracts\Repositories\SaasClientRepositoryInterface;
use App\Models\SaasClient;

/**
 * Repositório de SaasCliento, camada que chama o eloquent
 * para interagir com banco de dados, usando eloquent
 *
 * Camada para chamar Eloquent e iteragir com banco de dados.
 * Aqui não tem regras de negócio. Elas ficam nos actins.
 * Os actions e repositories são chamados onde for necessário, ex.: controllers
 */
class SaasClientRepository implements SaasClientRepositoryInterface
{
    /**
     * Injetamos o model SaasClient
     *
     * @param SaasClient $saasClient
     */
    public function __construct(
        protected SaasClient $saasClient
    )
    {
    }

    /**
     * Retorna todos os registros
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listAll()
    {
        return $this->saasClient->filter()->get();
    }

    /**
     * Busca um registro pelo ID
     *
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->saasClient->find($id);
    }

    /**
     * Cria um registro novo
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->saasClient->create($data);
    }

    /**
     * Atualiza um registro
     *
     * @param $id
     * @param array $data
     * @return null
     */
    public function update($id, array $data)
    {
        $saasClient = $this->saasClient->find($id);

        if ($saasClient) {
            $saasClient->update($data);
            return $saasClient;
        }

        return null;
    }

    /**
     * Deleta um registro
     *
     * @param $id
     * @param null $deletedBy
     * @return bool
     */
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
