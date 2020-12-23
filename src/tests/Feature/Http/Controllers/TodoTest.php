<?php

namespace Tests\Feature\Http\Controllers;

use App\Helpers\ApiProblem;
use App\Models\Todo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTodoList()
    {
        Todo::factory()->count(25)->create();

        $response = $this->getJson(route('todos.index'));

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
    public function testTodoCreate()
    {
        $todo = Todo::factory()->make();

        $response = $this->postJson(route('todos.store'), [
            'name' => $todo->getAttribute('name')
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'created_at', 'updated_at']);
        $response->assertJsonPath('name', $todo->getAttribute('name'));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTodoCreateDuplicate()
    {
        $name = 'Pay the bills';
        Todo::factory()->create([
            'name' => $name
        ]);

        $response = $this->postJson(route('todos.store'), [
            'name' => $name
        ]);

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
    public function testTodoRead()
    {
        Todo::factory()->count(25)->create();

        $response = $this->getJson(route('todos.show', ['todo' => 1]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'created_at', 'updated_at']);
        $response->assertJsonPath('id', 1);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTodoReadNonExisting()
    {
        $response = $this->getJson(route('todos.show', ['todo' => 1]));

        $response->assertStatus(404);
        $response->assertJsonStructure(['status', 'type', 'title', 'detail']);
        $response->assertJsonPath('status', 404);
        $response->assertJsonPath('type', ApiProblem::TYPE_NOT_FOUND_ERROR);
        $response->assertJsonPath('title', ApiProblem::$titles[ApiProblem::TYPE_NOT_FOUND_ERROR]);
        $response->assertJsonPath('detail', 'No Todo resource found for 1');
    }

    /**
     * Test updating of a Todo resource.
     *
     * @return void
     */
    public function testTodoUpdate()
    {
        /** @var Todo $team */
        $team = Todo::factory()->create();

        $name = 'Pay the bills';
        $response = $this->putJson(
            route('todos.update', ['todo' => $team->getKey()]),
            [
                'name' => $name,
            ]
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'created_at', 'updated_at']);
        $response->assertJsonPath('id', $team->getKey());
        $response->assertJsonPath('name', $name);
    }

    /**
     * Test updating of a Todo resource.
     *
     * @return void
     */
    public function testTodoUpdateInvalidData()
    {
        /** @var Todo $team */
        $team = Todo::factory()->create();

        $name = 'Pay the bills';
        $response = $this->putJson(
            route('todos.update', ['todo' => $team->getKey()]),
            [
                'title' => $name,
            ]
        );

        $response->assertStatus(422);
        $response->assertJsonStructure(['status', 'type', 'title', 'errors']);
        $response->assertJsonPath('status', 422);
        $response->assertJsonPath('type', ApiProblem::TYPE_VALIDATION_ERROR);
        $response->assertJsonPath('title', ApiProblem::$titles[ApiProblem::TYPE_VALIDATION_ERROR]);
        $response->assertJsonStructure(['errors' => ['name']]);
    }
}
