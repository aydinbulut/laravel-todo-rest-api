<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *      path="/tasks",
     *      summary="Get list of task resources.",
     *      tags={"Task"},
     *      @OA\Parameter(name="todo", description="Todo ID number", @OA\Schema(type="integer"), in="query", required=true),
     *      @OA\Parameter(name="page", description="page number", @OA\Schema(type="integer"), in="query"),
     *      @OA\Response(
     *          response="200",
     *          description="successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="data",
     *                      type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          allOf={
     *                              @OA\Property(ref="#/components/schemas/Task"),
     *                          }
     *                      )
     *                  ),
     *                  allOf={
     *                      @OA\Property(ref="#/components/schemas/PaginationWithoutData")
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="400-599",
     *          description="unsuccessful operation",
     *          @OA\MediaType(
     *              mediaType="application/problem+json",
     *              @OA\Schema(
     *                  type="object",
     *                  allOf={
     *                      @OA\Property(ref="#/components/schemas/ProblemResponse")
     *                  }
     *              )
     *          )
     *      )
     * )
     *
     * @param ListTaskRequest $request
     * @return JsonResponse
     */
    public function index(ListTaskRequest $request)
    {
        $result = Task::where('todo_id', (int)$request->get('todo'))->paginate();

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request)
    {
        /** @var Task $task */
        $task = Task::create($request->only('name', 'todo_id'));

        return response()->json($task->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function show(Task $task)
    {
        return response()->json($task->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}