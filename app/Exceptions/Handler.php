<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    
    protected $dontReport = [
        // 報告しない例外クラス
    ];
    
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }
    
    public function render($request, Throwable $exception)
    {
        // モデルが見つからない場合のカスタム処理
        if ($exception instanceof ModelNotFoundException) {
            return response()->view('errors.404', [], 404);
        }

        // URLが見つからない場合のカスタム処理
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        // それ以外の例外に対するデフォルトの処理
        return parent::render($request, $exception);
    }
    
}
