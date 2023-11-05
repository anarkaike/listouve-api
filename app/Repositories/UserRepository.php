<?php
namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

/**
 * Repositório de usuário, camada que chama o eloquent
 * para interagir com banco de dados, usando eloquent
 *
 * Camada para chamar Eloquent e iteragir com banco de dados.
 * Aqui não tem regras de negócio. Elas ficam nos actins.
 * Os actions e repositories são chamados onde for necessário, ex.: controllers
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * Injetamos o model User
     *
     * @param User $user
     */
    public function __construct(
        protected User $user
    ){
    }

    /**
     * Retorna todos os registros
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listAll()
    {
        return $this->user->all();
    }


    /**
     * Busca um registro pelo ID
     *
     * @param $id
     * @return mixed
     */
    public function findbyId($id)
    {
        return $this->user->find($id);
    }


    /**
     * Cria um registro novo
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->user->create($data);
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
        $user = $this->user->find($id);

        if ($user) {
            $user->update($data);
            return $user;
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
        $user = $this->user->find($id);

        $user->deleted_by = $deletedBy;
        $user->update();

        if ($user) {
            $user->delete();
            return true;
        }

        return false;
    }
}
