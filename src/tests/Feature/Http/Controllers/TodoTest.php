<?php

namespace Tests\Feature\Http\Controllers;

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
}
