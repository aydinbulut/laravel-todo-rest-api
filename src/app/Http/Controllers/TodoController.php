<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *      path="/todos",
     *      summary="Get list of todo resources.",
     *      tags={"Todo"},
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
     *                              @OA\Property(ref="#/components/schemas/Todo"),
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
     * @return JsonResponse
     */
    public function index()
    {
        $result = Todo::paginate();

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/todos",
     *      summary="Creat a todo resource.",
     *      tags={"Todo"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Property(ref="#/components/schemas/Todo")
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
     *                      @OA\Property(ref="#/components/schemas/Todo")
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
     * @param StoreTodoRequest $request
     * @return JsonResponse
     */
    public function store(StoreTodoRequest $request)
    {
        /** @var Todo $todo */
        $todo = Todo::create($request->only('name'));

        return response()->json($todo->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *      path="/todos/{todo}",
     *      summary="Get a todo resource.",
     *      tags={"Todo"},
     *      @OA\Parameter(name="todo", description="ID of Todo", @OA\Schema(type="integer"), in="path"),
     *      @OA\Response(
     *          response="200",
     *          description="successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  allOf={
     *                      @OA\Property(ref="#/components/schemas/Todo")
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
     * @param Todo $todo
     * @return JsonResponse
     */
    public function show(Todo $todo)
    {
        return response()->json($todo->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *      path="/todos/{todo}",
     *      summary="Update a todo resource.",
     *      tags={"Todo"},
     *      @OA\Parameter(name="todo", description="ID of Todo", @OA\Schema(type="integer"), in="path"),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Property(ref="#/components/schemas/Todo")
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
     *                      @OA\Property(ref="#/components/schemas/Todo")
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
     * @param Request $request
     * @param Todo $todo
     * @return JsonResponse
     */
    public function update(Request $request, Todo $todo)
    {
        $todo->fill($request->only('name'));
        $todo->save();
        $todo = $todo->fresh();

        return response()->json($todo->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
