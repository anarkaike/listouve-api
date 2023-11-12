<?php

namespace App\Contracts\Actions;

/**
 * Interface generica para padronizar metodos dos Actions (classe que faz queries eloquent)
 */
interface ActionInterface
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
    public function findById(int $id);

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
    public function update(int $id, array $data);

    /**
     * Deleta um registro
     *
     * @param $id
     * @return mixed
     */
    public function delete(int $id, int $deletedBy = null);
}
