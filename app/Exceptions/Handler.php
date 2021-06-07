<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @param \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect('/');
        }

        if ($this->isHttpException($exception)) {
//            return $this->renderHttpException($exception);
            switch ($exception->getStatusCode()) {
//                // Method Not Allowed
//                case '305':
//                    return $this->renderHttpException($exception);
//                    break;
//                // Not Found
//                case '404':
//                    return $this->renderHttpException($exception);
//                    break;
//                // Page Expired
                case '419':
//                    return $this->renderHttpException($exception);
                    return redirect('/');
                    break;
//                // Internal Server Error
                case '500':
//                    return $this->renderHttpException($exception);
                    return redirect('/');
                    break;
                default:
                    return $this->renderHttpException($exception);
                    break;
            }
        }
        return parent::render($request, $exception);
    }
}
