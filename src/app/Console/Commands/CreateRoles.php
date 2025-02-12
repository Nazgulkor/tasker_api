<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Создание пермишнов...');

        Permission::firstOrCreate(['name' => 'view all users']);
        Permission::firstOrCreate(['name' => 'update own profile']);
        Permission::firstOrCreate(['name' => 'delete user']);
        Permission::firstOrCreate(['name' => 'manage tasks']);

        $this->info('Пермишны созданы успешно!');

        $this->info('Создание ролей...');

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $adminRole->givePermissionTo(['view all users', 'update own profile', 'delete user', 'manage tasks']);
        $userRole->givePermissionTo(['update own profile', 'manage tasks']);

        $this->info('Роли и пермишны созданы и назначены успешно!');
    }
}
