<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;

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

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {

            if ($exception instanceof ModelNotFoundException) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Resource not found'
                ], 404);
            }

            if ($exception instanceof NotFoundHttpException) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Route not found'
                ], 404);
            }

            if ($exception instanceof AuthenticationException) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            if ($exception instanceof AuthorizationException) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Forbidden'
                ], 403);
            }

            if ($exception instanceof ValidationException) {

                return response()->json([
                    'status' => 'error',
                    'message' => $exception->errors()
                ], 422);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred',
                'error' => $exception->getMessage()
            ], 500);
        }
        return parent::render($request, $exception);
    }

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
    }
}
