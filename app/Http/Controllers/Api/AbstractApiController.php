<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AbstractApiController extends Controller
{
    protected $jsonResponse = ['success' => false, 'message' => '', 'data' => null];
}