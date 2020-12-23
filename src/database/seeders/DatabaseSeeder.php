<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use App\Models\Todo;
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
        Todo::factory()->count(25)->create();
    }
}
