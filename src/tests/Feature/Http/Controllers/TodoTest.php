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

        $response->assertJsonStructure(['data', 'total', 'from', 'to']);
        $response->assertJsonPath('total', 25);
        $response->assertJsonPath('from', 1);
        $response->assertJsonPath('to', 15);
        $response->assertJsonPath('per_page', 15);
    }
}
