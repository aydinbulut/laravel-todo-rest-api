<?php

namespace Database\Seeders;

use App\Models\Task;
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
        Todo::factory()
            ->count(25)
            ->has(Task::factory()
                ->count(5)
                ->state(function (array $attributes, Todo $todo) {
                    return [
                        'todo_id' => $todo->getKey(),
                    ];
                }))
            ->create();
    }
}
