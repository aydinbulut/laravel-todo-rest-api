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

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTaskCreate()
    {
        $todo = Todo::factory()->create();
        $task = Task::factory()->make();

        $response = $this->postJson(route('tasks.store'), [
            'name' => $task->getAttribute('name'),
            'todo_id' => $todo->getKey(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'todo_id', 'created_at', 'updated_at']);
        $response->assertJsonPath('name', $task->getAttribute('name'));
        $response->assertJsonPath('todo_id', $todo->getKey());
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTaskCreateWithInvalidData()
    {
        $response = $this->postJson(route('tasks.store'), []);

        $response->assertStatus(422);
        $response->assertJsonStructure(['status', 'type', 'title', 'errors']);
        $response->assertJsonPath('status', 422);
        $response->assertJsonPath('type', ApiProblem::TYPE_VALIDATION_ERROR);
        $response->assertJsonPath('title', ApiProblem::$titles[ApiProblem::TYPE_VALIDATION_ERROR]);
        $response->assertJsonStructure(['errors' => ['name', 'todo_id']]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTaskRead()
    {
        Task::factory()
            ->for(Todo::factory())
            ->count(5)
            ->create();

        $response = $this->getJson(route('tasks.show', ['task' => 1]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'created_at', 'updated_at']);
        $response->assertJsonPath('id', 1);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTaskReadNonExisting()
    {
        $response = $this->getJson(route('tasks.show', ['task' => 1]));

        $response->assertStatus(404);
        $response->assertJsonStructure(['status', 'type', 'title', 'detail']);
        $response->assertJsonPath('status', 404);
        $response->assertJsonPath('type', ApiProblem::TYPE_NOT_FOUND_ERROR);
        $response->assertJsonPath('title', ApiProblem::$titles[ApiProblem::TYPE_NOT_FOUND_ERROR]);
        $response->assertJsonPath('detail', 'No Task resource found for 1');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTaskUpdate()
    {
        /** @var Task $team */
        $task = Task::factory()->for(Todo::factory())->create();

        $name = 'Pay the heating bills';
        $response = $this->putJson(
            route('tasks.update', ['task' => $task->getKey()]),
            [
                'name' => $name,
            ]
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'todo_id', 'created_at', 'updated_at']);
        $response->assertJsonPath('id', $task->getKey());
        $response->assertJsonPath('name', $name);
        $response->assertJsonPath('todo_id', $task->getAttribute('todo_id'));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTaskUpdateInvalidData()
    {
        /** @var Task $team */
        $task = Task::factory()->for(Todo::factory())->create();

        $name = 'Pay the heating bills';
        $response = $this->putJson(route('tasks.update', ['task' => $task->getKey()]), []);

        $response->assertStatus(422);
        $response->assertJsonStructure(['status', 'type', 'title', 'errors']);
        $response->assertJsonPath('status', 422);
        $response->assertJsonPath('type', ApiProblem::TYPE_VALIDATION_ERROR);
        $response->assertJsonPath('title', ApiProblem::$titles[ApiProblem::TYPE_VALIDATION_ERROR]);
        $response->assertJsonStructure(['errors' => ['name']]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteTask()
    {
        $task = Task::factory()->for(Todo::factory())->create();

        $response = $this->deleteJson(route('tasks.destroy', ['task' => $task->getKey()]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'created_at', 'updated_at']);
        $response->assertJsonPath('id', $task->getKey());
        $response->assertJsonPath('name', $task->getAttribute('name'));
        $response->assertJsonPath('todo_id', $task->getAttribute('todo_id'));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteTaskNonExisting()
    {
        $response = $this->deleteJson(route('tasks.destroy', ['task' => 1]));

        $response->assertStatus(404);
        $response->assertJsonStructure(['status', 'type', 'title', 'detail']);
        $response->assertJsonPath('status', 404);
        $response->assertJsonPath('type', ApiProblem::TYPE_NOT_FOUND_ERROR);
        $response->assertJsonPath('title', ApiProblem::$titles[ApiProblem::TYPE_NOT_FOUND_ERROR]);
        $response->assertJsonPath('detail', 'No Task resource found for 1');
    }
}
