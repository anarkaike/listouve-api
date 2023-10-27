<?php

namespace Tests\Unit\Actions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\{
    Actions\UserAction,
    Enums\User\UserStatusEnum,
    Models\User,
    Repositories\UserRepository,
};

/**
 * Testes para UserAction
 */
class UserActionTest extends TestCase
{
    public function __construct(string $name)
    {
        parent::__construct(name: $name);
        Auth::shouldReceive('id')->andReturn(1);
    }

    public function test_list_all()
    {
        // Criando um usuário para usar nos testes
        $user = User::factory()->create();

        // Criando uma instância de UserAction com um repositório real (não um mock)
        $userRepository = $this->app->make(abstract: UserRepository::class);
        $userAction = new UserAction(userRepository: $userRepository);

        // Testando o método listAll
        $result = $userAction->listAll();

        // Testando se o resultado contém o usuário que criamos
        $this->assertTrue(condition: $result->contains($user));
    }

    public function test_find_by_id()
    {
        // Criando um usuário para usar nos testes
        $user = User::factory()->create();

        // Criando uma instância de UserAction com um repositório real (não um mock)
        $userRepository = $this->app->make(abstract: UserRepository::class);
        $userAction = new UserAction(userRepository: $userRepository);

        // Chamando o método listAll
        $userFound = $userAction->findById(id: $user->id);

        // Testando se o resultado contém o usuário que criamos
        $this->assertEquals(expected: $user->id, actual: $userFound->id);
        $this->assertEquals(expected: $user->name, actual: $userFound->name);
        $this->assertEquals(expected: $user->email, actual: $userFound->email);

        // Tentando encontrar um usuário com um ID inexistente
        // e testando se lança ModelNotFoundException
        //$this->expectException(ModelNotFoundException::class);
        //$userAction->findById(id: 9999);
    }

    public function teste_create()
    {
        // Dados do usuário que você vamos criar
        $updatedData = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => fake()->password(6, 8),
//            'phone_personal' => fake()->phoneNumber(),
//            'phone_professional' => fake()->phoneNumber(),
            'url_photo' => fake()->imageUrl(),
            'status' => UserStatusEnum::ACTIVE->value,
        ];

        // Criando uma instância de UserAction com um repositório real (não um mock)
        $userRepository = $this->app->make(abstract: UserRepository::class);
        $userAction = new UserAction(userRepository: $userRepository);

        //var_dump(Auth::id());exit;
        // Chamando o método create
        $createdUser = $userAction->create(data: $updatedData);

        // Testando se o usuário foi criado corretamente no base de dados
        $this->assertDatabaseHas(table: 'users',
            data: [
                'name' => $updatedData['name'],
                'email' => $updatedData['email'],
//                'phone_personal' => $updatedData['phone_personal'],
//                'phone_professional' => $updatedData['phone_professional'],
                'url_photo' => $updatedData['url_photo'],
                'status' => $updatedData['status'],
            ]
        );

        // Testando se os dados do usuário criado correspondem aos dados fornecidos
        $this->assertEquals(expected: $updatedData['name'], actual: $createdUser->name);
        $this->assertEquals(expected: $updatedData['email'], actual: $createdUser->email);
//        $this->assertEquals(expected: $updatedData['phone_personal'], actual: $createdUser->phone_personal);
//        $this->assertEquals(expected: $updatedData['phone_professional'], actual: $createdUser->phone_professional);
        $this->assertEquals(expected: $updatedData['url_photo'], actual: $createdUser->url_photo);
        $this->assertEquals(expected: $updatedData['status'], actual: $createdUser->status);
    }

    public function teste_update()
    {
        // Criando um usuário para usar nos testes
        $user = User::factory()->create();

        // Dados novos para atualizar o registro na base de dados
        $updatedData = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => fake()->password(6, 8),
//            'phone_personal' => fake()->phoneNumber(),
//            'phone_professional' => fake()->phoneNumber(),
            'url_photo' => fake()->imageUrl(),
            'status' => UserStatusEnum::ACTIVE->value,
        ];

        // Criando uma instância de UserAction com um repositório real (não um mock)
        $userRepository = $this->app->make(abstract: UserRepository::class);
        $userAction = new UserAction($userRepository);

        $updatedUser = $userAction->update(id: $user->id, data: $updatedData);

        // testando se os dados do usuário foram atualizados corretamente na base de dados
        $this->assertDatabaseHas(table: 'users',
            data: [
                'name' => $updatedData['name'],
                'email' => $updatedData['email'],
//                'phone_personal' => $updatedData['phone_personal'],
//                'phone_professional' => $updatedData['phone_professional'],
                'url_photo' => $updatedData['url_photo'],
                'status' => $updatedData['status'],
            ]
        );

        // Testando se os dados do usuário atualizado correspondem aos dados fornecidos
        $this->assertEquals(expected: $updatedData['name'], actual: $updatedUser->name);
        $this->assertEquals(expected: $updatedData['email'], actual: $updatedUser->email);
    }

    public function test_delete()
    {
        // Criando um usuário para usar nos testes
        $user = User::factory()->create();

        // Criando uma instância de UserAction com um repositório real (não um mock)
        $userRepository = $this->app->make(abstract: UserRepository::class);
        $userAction = new UserAction($userRepository);

        // Chamando o método delete para remover o usuário
        $deleted = $userAction->delete(id: $user->id);

        // testando se o método delete retornou true, indicando que a exclusão foi bem-sucedida
        $this->assertTrue(condition: $deleted);

        // Tentando encontrar o usuário excluído
        // e testando se lança ModelNotFoundException
        $this->expectException(exception: ModelNotFoundException::class);
        User::findOrFail($user->id); // Deve lançar uma exceção
    }
}
