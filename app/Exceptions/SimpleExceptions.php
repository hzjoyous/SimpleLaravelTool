<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SimpleExceptions extends Exception
{
    /**
     * @param Request
     * @return Response
     */
    public function render($request)
    {
        return response($this->getMessage() ?: '发生异常啦');
    }
}
