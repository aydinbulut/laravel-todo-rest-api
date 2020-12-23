<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API",
 *      description="API OpenApi description",
 *      @OA\Contact(
 *          email="aydin.blt@gmail.com"
 *      )
 * )
 * @OA\Server(
 *     url="/api"
 * )
 * @OA\Schema(
 *      schema="ProblemResponse",
 *      required={"status", "type", "title"},
 *      @OA\Property(property="status", type="integer", example=422),
 *      @OA\Property(property="type", type="string"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="detail", type="string"),
 *      @OA\Property(
 *          property="errors",
 *          type="object",
 *          description="This object may not be provided, it will return invalid parameters with error messages"
 *     ),
 * )
 * @OA\Schema(
 *      schema="PaginationWithoutData",
 *      @OA\Property(
 *          property="current_page",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="first_page_url",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="from",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="last_page",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="last_page_url",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="next_page_url",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="path",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="per_page",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="prev_page_url",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="to",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="total",
 *          type="integer"
 *      )
 * )
 * @OA\Schema(
 *      schema="Timestampable",
 *      required={"created_at", "updated_at"},
 *      @OA\Property(property="created_at", type="string", readOnly=true),
 *      @OA\Property(property="updated_at", type="string", readOnly=true),
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
