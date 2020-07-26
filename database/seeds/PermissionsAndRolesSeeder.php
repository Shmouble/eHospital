<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\User;

class PermissionsAndRolesSeeder extends Seeder
{
    /**
     * Creates roles and permissions
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::create(['name' => 'root.hospital']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        $role->givePermissionTo('create user');
        $role->givePermissionTo('edit user');

        $role = Role::create(['name' => 'manager.hospital']);
        Permission::create(['name' => 'create schedule']);
        $role->givePermissionTo('create schedule');

        $role = Role::create(['name' => 'doctor.hospital']);
        Permission::create(['name' => 'check schedule']);
        Permission::create(['name' => 'write appointment data']);
        $role->givePermissionTo('check schedule');
        $role->givePermissionTo('write appointment data');

        $role = Role::create(['name' => 'patient.hospital']);
        Permission::create(['name' => 'edit personal data']);
        Permission::create(['name' => 'make an appointment']);
        $role->givePermissionTo('edit personal data');
        $role->givePermissionTo('make an appointment');

        // Главный root
        $user = User::create([ 
            'email' => 'Administrator@gmail.com',
            'password' => bcrypt('Administrator')]);
        $user->assignRole('root.hospital');
        // Пробный доктор
        $doctor = User::create([ 
            'email' => '654@gmail.com',
            'password' => bcrypt('12345678')]);
        $doctor->assignRole('doctor.hospital');
    }
}
