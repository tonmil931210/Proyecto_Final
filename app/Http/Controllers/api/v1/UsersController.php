<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;

use Log;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Support\Facades\Crypt;
# VERIFICAR STATUS CODE QUE ESTEN CORRECTOS
#FALTA PAGINACION
class UsersController extends Controller
{
    public function __construct()
    {
        $this -> middleware('isAdmin');
    }

    public function index() {
        $users = User::all();
        return Response() -> Json([
            'data' => [
                'Users' => $this -> transformCollection($users)
            ]
        ],200);
    }

    public function show($id) {
        $user = User::find($id);
        $status_code = 200;
        $message = '';
        $previous = '';
        $next = '';
        if ($user) {
            $previous = $this -> SearchingIds($user);
            $next = $this -> SearchingIds($user, '>');
        } else {
            $status_code = 404;
            $message = 'User does not found';
        }

        return Response() -> Json([
                'data' => [
                    'previous' => $previous,
                    'next' => $next,
                    'user' => $this -> transform($user),
                    'message' => $message
                ]
            ], $status_code);

    }

    public function store(UserRequest $request) {
        $status_code = 200;
        $message = '';
        $input = $request -> only(['name', 'email', 'password', 'type']);
        log::info($input);
        $user = User::create($input);
        log::info('entre2');
        if (!$user) {
            $status_code = 404;
            $message = 'problem with create user';
        }
        return Response() -> Json([
                    'data' => [
                        'user' => $this -> transform($user),
                        'message' => $message
                    ]
                ], $status_code);
    }

    public function update(UserRequest $request, $id) {
        $status_code = 200;
        $message = '';
        $user = User::find($id);
        $user -> name = $request -> name;
        $user -> email = $request -> email;
        $user -> password = $request -> password;
        $user -> type = $request -> type;
        $user -> save();
        if (!$user) {
            $status_code = 404;
            $message = 'problem with update user';
        }
        return Response() -> Json([
                'data' => [
                    'user' => $this -> transform($user),
                    'message' => $message
                ]
            ], $status_code);
}

    public function destroy($id) {
        $user = User::destroy($id);
        if ($user) {
            return Response() -> Json(['message' => 'ok'], 200);
        }
        return Response() -> Json(['message' => 'error'], 400);
    }

    private function transformCollection($users) {
    	return array_map([$this, 'transform'], $users -> toArray());
    }

    private function transform($user) {
    	return [
            'id' => $user['id'],
			'name' => $user['name'],
			'email' => $user['email'],
            'type' => $user['type'],	
    	];
    }

    private function SearchingIds($user, $type_search = '<') {
        $value = User::where('id', $type_search, $user -> id);
        if ($type_search == '<') {
            return $value -> max('id');
        } 
        return $value -> min('id');
    }
}
