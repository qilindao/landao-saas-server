<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        $error = $this->convertExceptionToResponse($exception);
        //Content-type:application/json，返回json
        if ($request->isJson() && $exception instanceof NotFoundHttpException) {
            return response()->json(['status' => 'error', 'code' => $error->getStatusCode(), 'message' => 'Not Found!'], $error->getStatusCode());
        }

        return parent::render($request, $exception);
    }

    /**
     * 重新未登录返回值特定json格式
     * 注意：前端需要设置header { Accept : application/json}
     * @param $request
     * @param AuthenticationException $exception
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response([
                'status' => 'error',
                'code' => 401,
                'message' => '请登录',
            ], 401)
            : redirect('/login');
    }
}
