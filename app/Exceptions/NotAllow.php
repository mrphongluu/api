<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class NotAllow extends Exception
{

    public function render()
    {
            return response()->json(['error' => 'The specified method for the request is invaild', 'code' => 405], 405);
    }
}
