<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use App\Models\{Event, EventList, EventListItem, SaasClient, User, Permission, Profile};


class DatabaseSeeder extends Seeder
{
    private User $userSuperAdmin;
    private array $profiles;
    private array $permissions;
    private array $saasClientDemos;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createSuperAdmin();
        Auth::login($this->userSuperAdmin);
        $this->createPermissions();
        $this->createProfiles();
        $this->addPermissionsToProfiles();
        $this->createSaasClientDemos();
        $this->addRelationsToSuperAdmin();
    }

    private function createSuperAdmin(): void {
        $this->userSuperAdmin = User::create(attributes: [
            'name'              => 'Junio',
            'email'             => 'anarkaike@gmail.com',
            'is_super_admin'    => true,
            'password'          => bcrypt(value: '123456'),
        ]);
    }

    private function addRelationsToSuperAdmin(): void {
        $this->userSuperAdmin->addProfile($this->profiles['adminSaas']['objModel']);
        $this->userSuperAdmin->addSaasClient($this->saasClientDemos[0]['objModel']);
    }

    private function createPermissions(): void
    {
        $this->permissions = [
            'saasClient' => [
                'viewAny' => ['name' => 'saasClient:viewAny', 'description' => 'Permitir listar todos os clientes saas.'],
                'view' => ['name' => 'saasClient:view', 'description' => 'Permitir recuperar um cliente saas.'],
                'create' => ['name' => 'saasClient:create', 'description' => 'Permitir cadastrar um cliente saas.'],
                'update' => ['name' => 'saasClient:update', 'description' => 'Permitir atualizar um cliente saas.'],
                'delete' => ['name' => 'saasClient:delete', 'description' => 'Permitir deletar um cliente saas.'],
                'justMine' => ['name' => 'saasClient:justMine', 'description' => 'Restringe gerenciar apenas registros próprios.'],
            ],

            'user' => [
                'viewAny' => ['name' => 'user:viewAny', 'description' => 'Permitir listar todos os usuários.'],
                'view' => ['name' => 'user:view', 'description' => 'Permitir recuperar um usuário.'],
                'create' => ['name' => 'user:create', 'description' => 'Permitir cadastrar um usuário.'],
                'update' => ['name' => 'user:update', 'description' => 'Permitir atualizar um usuário.'],
                'delete' => ['name' => 'user:delete', 'description' => 'Permitir deletar um usuário.'],
                'justMine' => ['name' => 'user:justMine', 'description' => 'Restringe gerenciar apenas registros próprios.'],
            ],

            'profile' => [
                'viewAny' => ['name' => 'profile:viewAny', 'description' => 'Permitir listar todos os perfil.'],
                'view' => ['name' => 'profile:view', 'description' => 'Permitir recuperar um perfil.'],
                'create' => ['name' => 'profile:create', 'description' => 'Permitir cadastrar um perfil.'],
                'update' => ['name' => 'profile:update', 'description' => 'Permitir atualizar um perfil.'],
                'delete' => ['name' => 'profile:delete', 'description' => 'Permitir deletar um perfil.'],
                'justMine' => ['name' => 'profile:justMine', 'description' => 'Restringe gerenciar apenas registros próprios.'],
            ],

            'permission' => [
                'viewAny' => ['name' => 'permission:viewAny', 'description' => 'Permitir listar todas as permissão.'],
                'view' => ['name' => 'permission:view', 'description' => 'Permitir recuperar uma permissão.'],
                'create' => ['name' => 'permission:create', 'description' => 'Permitir cadastrar uma permissão.'],
                'update' => ['name' => 'permission:update', 'description' => 'Permitir atualizar uma permissão.'],
                'delete' => ['name' => 'permission:delete', 'description' => 'Permitir deletar uma permissão.'],
                'justMine' => ['name' => 'permission:justMine', 'description' => 'Restringe gerenciar apenas registros próprios.'],
            ],

            'event' => [
                'viewAny' => ['name' => 'event:viewAny', 'description' => 'Permitir listar todos os evento.'],
                'view' => ['name' => 'event:view', 'description' => 'Permitir recuperar um evento.'],
                'create' => ['name' => 'event:create', 'description' => 'Permitir cadastrar um evento.'],
                'update' => ['name' => 'event:update', 'description' => 'Permitir atualizar um evento.'],
                'delete' => ['name' => 'event:delete', 'description' => 'Permitir deletar um evento.'],
                'justMine' => ['name' => 'event:justMine', 'description' => 'Restringe gerenciar apenas registros próprios.'],
            ],

            'eventList' => [
                'viewAny' => ['name' => 'eventList:viewAny', 'description' => 'Permitir listar todas as listas.'],
                'view' => ['name' => 'eventList:view', 'description' => 'Permitir recuperar uma lista.'],
                'create' => ['name' => 'eventList:create', 'description' => 'Permitir cadastrar uma lista.'],
                'update' => ['name' => 'eventList:update', 'description' => 'Permitir atualizar uma lista.'],
                'delete' => ['name' => 'eventList:delete', 'description' => 'Permitir deletar uma lista.'],
                'justMine' => ['name' => 'eventList:justMine', 'description' => 'Restringe gerenciar apenas registros próprios.'],
            ],

            'eventListItem' => [
                'viewAny' => ['name' => 'eventListItem:viewAny', 'description' => 'Permitir listar nomes da lista.'],
                'view' => ['name' => 'eventListItem:view', 'description' => 'Permitir recuperar um nome na lista.'],
                'create' => ['name' => 'eventListItem:create', 'description' => 'Permitir cadastrar um nome na lista.'],
                'update' => ['name' => 'eventListItem:update', 'description' => 'Permitir atualizar um nome na lista.'],
                'delete' => ['name' => 'eventListItem:delete', 'description' => 'Permitir deletar um nome na lista.'],
                'justMine' => ['name' => 'eventListItem:justMine', 'description' => 'Restringe gerenciar apenas registros próprios.'],
                'checkIn' => ['name' => 'eventListItem:checkIn', 'description' => 'Permitir marcar e desmarcar presença dos nomes da lista.'],
            ],
        ];

        foreach ($this->permissions as $entityName => &$permissionEntity) {
            foreach ($permissionEntity as &$permission) {
                $permission['model'] = ucfirst($entityName);
                $permission['objModel'] = Permission::create(attributes: $permission);
            }
        }
    }

    private function createProfiles(): void
    {
        $this->profiles = [
            'adminSaas'            => ['name' => 'Admin SaaS', 'description' => 'Usuário administrador do SaaS'],
            'revendedorSaas'       => ['name' => 'Revendedor SaaS', 'description' => 'Usuário revendedor do SaaS'],
            'donoEstabelecimento'  => ['name' => 'Dono de Estabelecimento', 'description' => 'Usuário dono de estabelecimento de entretenimento como boates e bares.'],
            'produtorDeFestas'     => ['name' => 'Produtor de Festas', 'description' => 'Usuário produtor de festas.'],
            'cerimonialista'        => ['name' => 'Cerimonialista', 'description' => 'Usuário organizador de cerimonias.'],
            'recepcionista'         => ['name' => 'Recepcionista', 'description' => 'Usuário recepcionista de convidados.'],
            'promoter'              => ['name' => 'Promoter', 'description' => 'Usuário promoter de eventos.'],
            'convidado'             => ['name' => 'Convidado do Evento', 'description' => 'Usuário convidado do evento.'],
        ];

        foreach ($this->profiles as &$profile) {
            $profile['created_by'] = $this->userSuperAdmin->id;
            $profile['objModel'] = Profile::create($profile);
        }
    }

    private function addPermissionsToProfiles(): void
    {

        foreach ($this->profiles as $profileName => $profile) {
            foreach ($this->permissions as $entityName => $permissionEntity) {
                foreach ($permissionEntity as $permissionName => $permission) {

                    if ($profileName === 'adminSaas') {
                        if (
                            ($entityName === 'saasClient' && $permissionName !== 'justMine') ||
                            ($entityName === 'user' && $permissionName !== 'justMine') ||
                            ($entityName === 'profile' && $permissionName !== 'justMine') ||
                            ($entityName === 'permission' && $permissionName !== 'justMine')
                        ) {
                            $profile['objModel']->assignPermission($permission['name']);
                        }
                    }
                    if ($profileName === 'revendedorSaas') {
                        if (
                            ($entityName === 'saasClient') ||
                            ($entityName === 'user')
                        ) {
                            $profile['objModel']->assignPermission($permission['name']);
                        }
                    }
                    if ($profileName === 'donoEstabelecimento') {
                        if (
                            ($entityName === 'user' && $permissionName !== 'justMine') ||
                            ($entityName === 'event' && $permissionName !== 'justMine') ||
                            ($entityName === 'eventList' && $permissionName !== 'justMine') ||
                            ($entityName === 'eventListItem' && $permissionName !== 'justMine')
                        ) {
                            $profile['objModel']->assignPermission($permission['name']);
                        }
                    }
                    if ($profileName === 'produtorDeFestas') {
                        if (
                            ($entityName === 'user' && $permissionName !== 'justMine') ||
                            ($entityName === 'event' && $permissionName !== 'justMine') ||
                            ($entityName === 'eventList' && $permissionName !== 'justMine') ||
                            ($entityName === 'eventListItem' && $permissionName !== 'justMine')
                        ) {
                            $profile['objModel']->assignPermission($permission['name']);
                        }
                    }
                    if ($profileName === 'cerimonialista') {
                        if (
                            ($entityName === 'user' && $permissionName !== 'justMine') ||
                            ($entityName === 'event' && $permissionName !== 'justMine') ||
                            ($entityName === 'eventList' && $permissionName !== 'justMine') ||
                            ($entityName === 'eventListItem' && $permissionName !== 'justMine')
                        ) {
                            $profile['objModel']->assignPermission($permission['name']);
                        }
                    }
                    if ($profileName === 'recepcionista') {
                        if (
                            ($entityName === 'user' && ($permissionName === 'view' || $permissionName === 'viewAny')) ||
                            ($entityName === 'eventListItem' && $permissionName === 'checkIn')
                        ) {
                            $profile['objModel']->assignPermission($permission['name']);
                        }
                    }
                    if ($profileName === 'promoter') {
                        if (
                            ($entityName === 'user' && $permissionName !== 'justMine') ||
                            ($entityName === 'eventList' && $permissionName === 'checkIn') ||
                            ($entityName === 'eventListItem' && $permissionName === 'checkIn')
                        ) {
                            $profile['objModel']->assignPermission($permission['name']);
                        }
                    }
                    if ($profileName === 'convidado') {
                        if (
                            ($entityName === 'user')
                        ) {
                            $profile['objModel']->assignPermission($permission['name']);
                        }
                    }
                }
            }
        }
    }

    private function createSaasClientDemos () {
        $saasClientDemos = [];
        $saasClientDemos[]        = SaasClient::factory()->create([
            'company_name' => 'Boate Londom Pub',
            'contact_name' => 'Jorge',
            'domain_api' => 'londom.apilistme.junio.cc',
            'domain_front' => 'londom.listme.junio.cc',
            'email' => 'anarkaike+londomtestelistme@gmail.com',
            'phone' => '3432367230',
            'status' => 'active',
            'email_confirmed_at' => fake()->dateTime(),
        ]);
        $saasClientDemos[]        = SaasClient::factory()->create([
            'company_name' => 'Bar Rose',
            'contact_name' => 'Sandra',
            'domain_api' => 'rose.apilistme.junio.cc',
            'domain_front' => 'rose.listme.junio.cc',
            'email' => 'anarkaike+rosetestelistme@gmail.com',
            'phone' => '3432367230',
            'status' => 'active',
            'email_confirmed_at' => fake()->dateTime(),
        ]);
        $saasClientDemos[]        = SaasClient::factory()->create([
            'company_name' => 'Casamentos Uesley',
            'contact_name' => 'Uesley',
            'domain_api' => 'uesley.apilistme.junio.cc',
            'domain_front' => 'uesley.listme.junio.cc',
            'email' => 'anarkaike+uesleytestelistme@gmail.com',
            'phone' => '3432367230',
            'status' => 'active',
            'email_confirmed_at' => fake()->dateTime(),
        ]);

        $users                  = User::factory(count: 9)->create(['password' => '123456']);

        // Criando admins
        foreach ($users as $key => $user) {
            if (in_array($key, [0,1,2])){
                $user->addProfile($this->profiles['donoEstabelecimento']['objModel'], $saasClientDemos[0]->id);
                $user->addSaasClient($saasClientDemos[0]);
            }
            if (in_array($key, [3,4,5])){
                $user->addProfile($this->profiles['produtorDeFestas']['objModel'], $saasClientDemos[1]->id);
                $user->addSaasClient($saasClientDemos[1]);
            }
            if (in_array($key, [6,7,8])){
                $user->addProfile($this->profiles['cerimonialista']['objModel'], $saasClientDemos[2]->id);
                $user->addSaasClient($saasClientDemos[2]);
            }
        }

        $this->saasClientDemos = [];
        // Criando events, listas e nomes nas listas
        foreach ($saasClientDemos as $key => $saasClient) {
            $this->saasClientDemos[$key] = $saasClient->toArray();
            $this->saasClientDemos[$key]['objModel'] = $saasClient;
            if ($key == 0) {
                $createdBy = rand(1, 3);
            }
            if ($key == 1) {
                $createdBy = rand(4, 6);
            }
            if ($key == 2) {
                $createdBy = rand(7, 9);
            }

            for ($e=0; $e<=5; $e++) {
                $this->saasClientDemos[$key]['events'][$e] = Event::factory()->create([
                    'saas_client_id' => $saasClient['id'],
                    'created_by' => $createdBy
                ]);
                for ($el=0; $el<5; $el++) {
                    $this->saasClientDemos[$key]['eventsLists'][$el] = EventList::factory()->create([
                        'saas_client_id' => $saasClient['id'],
                        'event_id' => $this->saasClientDemos[$key]['events'][$e]->id,
                        'created_by' => $createdBy
                    ]);
                    for ($eli=0; $eli<10; $eli++) {
                        $this->saasClientDemos[$key]['eventsListsItems'][$eli] = EventListItem::factory()->create([
                            'saas_client_id' => $saasClient['id'],
                            'event_id' => $this->saasClientDemos[$key]['events'][$e]->id,
                            'event_list_id' => $this->saasClientDemos[$key]['eventsLists'][$el]->id,
                            'created_by' => $createdBy
                        ]);
                    }
                }
            }
        }

        // Criando usuários recepcionistas, promoters e convidados
        $users = User::factory(count: 10)->create(['password' => '123456']);
        foreach ($users as $key => $user) {
            if ($key >= 0 && $key < 3) {
                $user->addProfile($this->profiles['recepcionista']['objModel'], $this->saasClientDemos[0]['id']);
            }
            if ($key >= 3 && $key < 6) {
                $user->addProfile($this->profiles['promoter']['objModel'], $this->saasClientDemos[1]['id']);
            }
            if ($key >= 6 && $key < 10) {
                $user->addProfile($this->profiles['convidado']['objModel'], $this->saasClientDemos[2]['id']);
            }
        }
    }
}
