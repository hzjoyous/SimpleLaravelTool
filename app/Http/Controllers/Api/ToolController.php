<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index($request)
    {
        return $this->simpleResponse('欢迎使用Tool Api');
    }

    public function opCacheClean()
    {
        if (function_exists('opcache_reset')) {
            $result = opcache_reset();
        } else {
            $result = false;
        }
        $message = $result ? 'opcache reset success' : 'no use opcache';
        return $this->simpleResponse($message);
    }
}
