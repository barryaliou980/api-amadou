<?php

namespace Database\Seeders;

use App\models\Instructor;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Instructor::factory()->count(5)->create();
    }
}
