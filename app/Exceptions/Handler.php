<?php

namespace App\Exceptions;

use App\Traits\Responser;
use BadMethodCallException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use Responser;
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // if ($exception instanceof ValidationException) {
        //     return $this->convertValidationExceptionToResponse($exception, $request);
        // }

        // if ($exception instanceof AuthenticationException) {
        //     return $this->unauthenticated($request, $exception);
        // }

        // if ($exception instanceof ModelNotFoundException) {
        //     $modelName = strtolower(class_basename($exception->getModel()));
        //     return $this->errorMessageResponse("Does not found $modelName for the given id.", 200); // 404
        // }

        // if ($exception instanceof AuthorizationException) {
        //     return $this->errorMessageResponse($exception->getMessage(), 200); // 403
        // }

        // if ($exception instanceof NotFoundHttpException) {
        //     return $this->errorMessageResponse("Specified url can not be found.", 200); // 404
        // }

        // if ($exception instanceof MethodNotFoundException) {
        //     return $this->errorMessageResponse("The specified method is invalid type.", 200); //404
        // }

        // if ($exception instanceof BadMethodCallException) {
        //     return $this->errorMessageResponse("The specified method is not available", 200); //404
        // }

        // if ($exception instanceof HttpException) {
        //     return $this->errorMessageResponse($exception->getMessage(), $exception->getStatusCode());
        // }

        // if ($exception instanceof QueryException) {
        //     return $this->errorMessageResponse("Query exception found", 200); // 500 Final code
        // }
        
        // if(config('app.debug')) {
            return parent::render($request, $exception);
        // }

        // return $this->errorMessageResponse('Unexpacted Exception error occured. Please try later', 500);
    }

    // protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    // {
    //     $errors = $e->validator->errors()->getMessages();
    //     return $this->errorMessageResponse($errors, 200); //422
    // }

    // protected function unauthenticated($request, AuthenticationException $exception)
    // {
    //     return $this->errorMessageResponse('Unauthenticated', 200); // 422
    // }
}
