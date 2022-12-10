<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // students
            'add-students',
            'update-students',
            'delete-students',
            'list-students',
            // instructors
            'add-instructors',
            'update-instructors',
            'delete-instructors',
            'list-instructors',
            // courses
            'add-courses',
            'update-courses',
            'delete-courses',
            'list-courses',
            // subjects
            'add-subjects',
            'update-subjects',
            'delete-subjects',
            'list-subjects',
            // schedules
            'add-schedules',
            'update-schedules',
            'delete-schedules',
            'list-schedules',
            // schedules
            'add-transactions',
            'update-transactions',
            'delete-transactions',
            'list-transactions',

        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());


        $role = Role::create(['name' => 'view-all'])
            ->givePermissionTo(['list-schedules', 'list-subjects', 'list-courses', 'list-instructors', 'list-students']);

        $role = Role::create(['name' => 'admin-transaction'])
            ->givePermissionTo([
                'add-transactions', 'update-transactions', 'delete-transactions', 'list-transactions',
            ]);
    }
}
