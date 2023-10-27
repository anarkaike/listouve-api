<?php

namespace App\Contracts\Repositories;

/**
 * Interface generica para padronizar metodos dos Repositorys (classe que faz queries eloquent)
 */
interface RepositoryInterface
{
    /**
     * Obtem todos os registros
     *
     * @return mixed
     */
    public function listAll();

    /**
     * Busca um registro pelo ID
     *
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * Cria um novo registro
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Atualiza um registro
     *
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Deleta um registro
     *
     * @param $id
     * @param null $deletedBy
     * @return bool
     */
    public function delete($id, $deletedBy = null): bool;
}
