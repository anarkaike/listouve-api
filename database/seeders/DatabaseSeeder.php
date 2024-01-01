<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    User,
    Permission,
    Profile,
};


class DatabaseSeeder extends Seeder
{
    private User $userSuperAdmin;
    private array $profiles;
    private array $permissions;

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
        $this->addProfilesToUsers();
    }

    private function createSuperAdmin(): void {
        $this->userSuperAdmin = User::create(attributes: [
            'name'              => 'Junio',
            'email'             => 'anarkaike@gmail.com',
            'is_super_admin'    => true,
            'password'          => bcrypt(value: '123456'),
        ]);
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
            'donoEstabelecimento'  => ['name' => 'Dono de Estabelecimento de Entretenimento', 'description' => 'Usuário dono de estabelecimento de entretenimento como boates e bares.'],
            'organizadorFesta'     => ['name' => 'Organizador de Festas', 'description' => 'Usuário organizador de festas.'],
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
                    if ($profileName === 'organizadorFesta') {
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

    private function addProfilesToUsers() {
        $this->userSuperAdmin->addProfile($this->profiles['adminSaas']['objModel'], null);
    }
}
