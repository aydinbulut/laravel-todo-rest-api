<?php

namespace App\Exceptions;

use App\Helpers\ApiProblem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e) {
            $apiProblem = new ApiProblem(500, ApiProblem::TYPE_SERVER_ERROR);

            if ($e instanceof ValidationException) {
                $apiProblem->setStatusCode(422);
                $apiProblem->setType(ApiProblem::TYPE_VALIDATION_ERROR);
                $apiProblem->addData('errors', $e->errors());
            }

            if ($e instanceof NotFoundHttpException) {
                $apiProblem->setStatusCode(404);
                $apiProblem->setType(ApiProblem::TYPE_NOT_FOUND_ERROR);
                preg_match('/.*\[App\\\\Models\\\\(.+)\]\s([0-9]+)/', $e->getMessage(), $matches);
                $apiProblem->addData('detail', sprintf('No %s resource found for %d', $matches[1], $matches[2]));
            }

            if (!$apiProblem->getData('detail')) {
                $apiProblem->addData('detail', $e->getMessage());
            }

            return response()->json($apiProblem->toArray(), $apiProblem->getStatusCode());
        });
    }
}
