<?php

namespace App\Http\Controllers;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
