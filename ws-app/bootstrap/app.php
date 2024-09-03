<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Responses\ApiResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, \Throwable $exception, Request $request) {
            $statusCode = $response->getStatusCode();
            $statusText = '';
            $message = $exception->getMessage();

            if (Lang::has('messages.ERR_'.$statusCode)) {
                $message = __('messages.ERR_'.$statusCode);
            }

            if (Lang::has('messages.STATUS_TEXT_'.$statusCode)) {
                $statusText = __('messages.STATUS_TEXT_'.$statusCode);
            }

            if ($exception instanceof \App\Exceptions\FailedValidationException) {
                $apiResponse = $exception->render();
            } else {
                $apiResponse = ApiResponse::error(
                    message:    $message,
                    statusCode: $statusCode,
                    statusText: $statusText,
                    exception:  $exception
                );
            }

            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($apiResponse->array()));

            return $response;
        });

        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            // APIs NotFoundHttpException
            if ($request->is(['api/*'])) {
                $statusCode = $exception->getStatusCode();
                $statusText = '';
                $message = $exception->getMessage();

                if (Lang::has('messages.ERR_'.$statusCode)) {
                    $message = __('messages.ERR_'.$statusCode);
                }

                if (Lang::has('messages.STATUS_TEXT_'.$statusCode)) {
                    $statusText = __('messages.STATUS_TEXT_'.$statusCode);
                }

                return response()->json(
                    ApiResponse::error(
                        message:    $message,
                        statusCode: $statusCode,
                        statusText: $statusText,
                        exception:  $exception
                    )->array(),
                    $statusCode
                );
            }
        });
    })->create();
