<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Response;

class TestsController extends Controller
{
    public function index() {
    	return Response() -> Json(['data' => 'hola'], 200);
    }
}
