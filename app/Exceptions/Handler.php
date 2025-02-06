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

    public function report(Throwable $exception) // <-- USE Throwable HERE
    {
        parent::report($exception);
    }
    public function render($request, Throwable $exception) // AND HERE
    {
        // if ($exception instanceof MethodNotAllowedHttpException) {
        //     return response()->json([
        //         'error' => 'Method Not Allowed',
        //         'message' => 'The requested method is not supported for this route.',
        //         'status' => 405
        //     ], 405);
        // }
        // return parent::render($request, $exception);

        if ($request->wantsJson()) {
            // Handle different types of exceptions
            if ($exception instanceof ModelNotFoundException) {
                // If a model is not found (e.g., no such resource)
                return response()->json([
                    'status' => 'error',
                    'message' => 'Resource not found'
                ], 404);
            }

            if ($exception instanceof NotFoundHttpException) {
                // Handle invalid routes
                return response()->json([
                    'status' => 'error',
                    'message' => 'Route not found'
                ], 404);
            }

            if ($exception instanceof AuthenticationException) {
                // Handle unauthenticated user
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            if ($exception instanceof AuthorizationException) {
                // Handle forbidden action
                return response()->json([
                    'status' => 'error',
                    'message' => 'Forbidden'
                ], 403);
            }

            if ($exception instanceof ValidationException) {
                // Handle validation errors
                return response()->json([
                    'status' => 'error',
                    'message' => $exception->errors()
                ], 422);
            }

            // Handle all other exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred',
                'error' => $exception->getMessage()
            ], 500);
        }

        // Default: If the request is not expecting JSON, return a default error page (e.g., HTML)
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
