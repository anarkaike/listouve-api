<?php

namespace Tests\Feature\Api\v1;

use Tests\AppTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Permission;

/**
 * Testa os en points do recurso usuários(permissions)
 */
class PermissionsTest extends AppTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->post(uri: '/api/v1/logout');
        Artisan::call(command: 'migrate:fresh'); // Resetando a base de dados
        $this->flushHeaders();
    }

    /**
     * Verifica um retorno com sucesso para o en point listAll
     *
     * @test
     */
    public function check_list_all_return_with_success(): void
    {
        $permissions = Permission::factory(count: 5)->create();
        $response = $this->token()->get(uri: '/api/v1/permissions');
        $response->assertStatus(status: 200);
        $response->assertJsonPath(path: "message", expect: trans(key: 'messages.permissions.list_all_success'));
        $response->assertJsonCount(count: 5, key: 'data'); // Um usuário é criado dentro de $this->token()
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [$this->permission(onlyKeys: true)],
            'metadata'
        ]);

        $keys = $this->permission(onlyKeys: true);
        foreach ($permissions as $k => $permission) {
            foreach ($keys as $key) {
                $response->assertJsonPath(path: "data.$k.$key", expect: $permission->$key);
            }
        }
    }

    /**
     * Retorna array com as keys de usuario com ou sem valores fake
     *
     * @param $onlyKeys
     * @return array|int[]|string[]
     */
    private function permission($onlyKeys = false) {
        $data = [
            'name'                  => fake()->name(),
        ];

        return $onlyKeys ? array_keys($data) : $data;
    }

}
