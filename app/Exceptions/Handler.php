<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        if ($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));
            return response()->json(['error' => 'Not found in ' . $modelName, 'code' => 404], 404);
        }
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($exception, $request);
        }
        if ($exception instanceof AuthorizationException) {
            return response()->json(['error' => $exception->getMessage(), 'code' => 403], 403);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['error' => 'The specified method for the request is invaild', 'code' => 405], 405);
        }
        if ($exception instanceof NotFoundHttpException) {
            return response()->json(['error' => 'The specified URL cannot be found ', 'code' => 404], 404);
        }
        if ($exception instanceof HttpException) {
            return response()->json(['error' => $exception->getMessage(), 'code' => $exception->getStatusCode()], $exception->getStatusCode());
        }
        if ($exception instanceof QueryException) {
            $exCode = $exception->errorInfo['1'];
            if ($exCode == 1451) {
                return response()->json(['error' => 'Cannot remove this resource permanently. It related  with another resource', 'code' => $exCode], 409);
            }
        }
        return parent::render($request, $exception);
    }
}
