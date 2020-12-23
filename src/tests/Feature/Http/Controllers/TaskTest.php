<?php

namespace Tests\Feature\Http\Controllers;

use App\Helpers\ApiProblem;
use App\Models\Task;
use App\Models\Todo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTaskList()
    {
        Task::factory()
            ->for(Todo::factory())
            ->count(25)
            ->create();

        $response = $this->getJson(route('tasks.index', ['todo' => 1]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'total', 'from', 'to']);
        $response->assertJsonPath('total', 25);
        $response->assertJsonPath('from', 1);
        $response->assertJsonPath('to', 15);
        $response->assertJsonPath('per_page', 15);
    }
}
