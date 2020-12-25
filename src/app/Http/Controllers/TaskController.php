<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
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
     * @OA\Post(
     *      path="/tasks",
     *      summary="Creat a task resource.",
     *      tags={"Task"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Property(ref="#/components/schemas/Task")
     *                  }
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  allOf={
     *                      @OA\Property(ref="#/components/schemas/Task")
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
     * @OA\Get(
     *      path="/tasks/{task}",
     *      summary="Get a task resource.",
     *      tags={"Task"},
     *      @OA\Parameter(name="task", description="ID of Task", @OA\Schema(type="integer"), in="path", required=true),
     *      @OA\Response(
     *          response="200",
     *          description="successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  allOf={
     *                      @OA\Property(ref="#/components/schemas/Task")
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
     * @OA\Put(
     *      path="/tasks/{task}",
     *      summary="Update a task resource.",
     *      tags={"Task"},
     *      @OA\Parameter(name="task", description="ID of Task", @OA\Schema(type="integer"), in="path", required=true),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Property(ref="#/components/schemas/Task:update")
     *                  }
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  allOf={
     *                      @OA\Property(ref="#/components/schemas/Task")
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
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->fill($request->only('name'));
        $task->save();

        return response()->json($task->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *      path="/tasks/{task}",
     *      summary="Delete a task resource.",
     *      tags={"Task"},
     *      @OA\Parameter(name="task", description="ID of Task", @OA\Schema(type="integer"), in="path", required=true),
     *      @OA\Response(
     *          response="200",
     *          description="successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  allOf={
     *                      @OA\Property(ref="#/components/schemas/Task")
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
     * @param Task $task
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json($task->toArray());
    }

    /**
     * Update the specified resource as completed in storage.
     *
     * @OA\Post(
     *      path="/tasks/{task}/markAsCompleted",
     *      summary="Mark a task resource as completed.",
     *      tags={"Task"},
     *      @OA\Parameter(name="task", description="ID of Task", @OA\Schema(type="integer"), in="path", required=true),
     *      @OA\Response(
     *          response="200",
     *          description="successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  allOf={
     *                      @OA\Property(ref="#/components/schemas/Task")
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
     * @param Task $task
     * @return JsonResponse
     */
    public function markAsCompleted(Task $task)
    {
        $task->setAttribute('completed', true);
        $task->save();

        return response()->json($task->toArray());
    }
}
