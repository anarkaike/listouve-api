<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use App\Models\{Event, EventList, EventListItem, SaasClient, User};
use Database\Seeders\{PermissionSeeder, ProfileSeeder, SaasClientSeeder};


class DatabaseSeeder extends Seeder
{
    private User $userSuperAdmin;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createSuperAdmin();
        Auth::login($this->userSuperAdmin);
        $this->call(PermissionSeeder::class);
        $this->call(ProfileSeeder::class);
        $this->call(SaasClientSeeder::class);
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

}