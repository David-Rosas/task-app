<?php

namespace Database\Seeders;

use App\Models\StatusTask;
use App\Models\User;
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

        User::factory()->create([
            'name' => "DavidR",
            'first_name' => 'David',
            'last_name' => 'Rosas',
            'email' => 'davidr@example.com',
            'password' => bcrypt(123123),
        ]);

  
        StatusTask::create(['name' => 'Creada']);
        StatusTask::create(['name' => 'En progreso']);
        StatusTask::create([ 'name' => 'Finalizada']);
   }
}
