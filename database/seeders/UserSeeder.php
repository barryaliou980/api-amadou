<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => "super@gmail.com",
            "name" => "Super Admin Role",
            "password" => Hash::make('test1234'),
        ])
            // ;
            // $role = Role::create(['name' => 'Admin']);
            // $permissions = Permission::pluck('id', 'id')->all();
            // $role->syncPermissions($permissions);
            // $user->assignRole([$role->id]);
            ->each(
                function ($user) {
                    $user->assignRole('super-admin');
                }
            );
        User::factory()->count(1)->create([
            'email' => "view@gmail.com",
            "name" => "View Role",
            "password" => Hash::make('test1234'),
        ])->each(
            function ($user) {
                $user->assignRole('view-all');
            }
        );
        User::factory()->count(1)->create([
            'email' => "transaction@gmail.com",
            "name" => "Transaction Admin Role",
            "password" => Hash::make('test1234'),
        ])->each(
            function ($user) {
                $user->givePermissionTo('add-transactions');
                $user->givePermissionTo('update-transactions');
                $user->givePermissionTo('list-transactions');
                $user->givePermissionTo('delete-transactions');
            }
        );
        User::factory()->count(1)->create([
            'email' => "user@gmail.com",
            "name" => "User Role",
            "password" => Hash::make('test1234'),
        ]);
        //
    }
}
