<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Instructor::factory(10)->create();
        \App\Models\Student::factory(10)->create();
        \App\Models\Course::factory(10)->create();

        $this->call([
            RolesAndPermissionSeeder::class,
            UserSeeder::class,
        ]);
    }
}
