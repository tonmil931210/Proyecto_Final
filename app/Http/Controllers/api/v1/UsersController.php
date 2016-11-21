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
        log::info("entro a index user");
        $users = User::all();
        return Response() -> Json([
            'data' => [
                'Users' => $this -> transformCollection($users)
            ]
        ],200);
    }

    public function show($id) {
        log::info("entro a show user");
        $user = User::find($id);
        $status_code = 200;
        $message = 'Todo ocurrió satisfactoriamente';
        $previous = '';
        $next = '';
        if ($user) {
            $previous = $this -> SearchingIds($user);
            $next = $this -> SearchingIds($user, '>');
        } else {
            $status_code = 400;
            $message = 'No se encontro el usuario';
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
        log::info("entro a store user");
        $status_code = 200;
        $message = 'Todo ocurrió satisfactoriamente';
        $input = $request -> only(['name', 'email', 'password', 'type']);
        log::info($input);
        $user = User::create($input);
        if (!$user) {
            $status_code = 400;
            $message = 'Problemas con guardar un usuario';
        }
        return Response() -> Json([
                    'data' => [
                        'user' => $this -> transform($user),
                        'message' => $message
                    ]
                ], $status_code);
    }

    public function update(UserRequest $request, $id) {
        log::info("entro a update user");
        $status_code = 200;
        $message = 'Todo ocurrió satisfactoriamente';
        $user = User::find($id);
        $user -> name = $request -> name;
        $user -> email = $request -> email;
        if ($request -> has('password')) {
            $user -> password = $request -> password;
        } 
        $user -> type = $request -> type;
        $user -> save();
        if (!$user) {
            $status_code = 400;
            $message = 'Problemas con actualizar el usuario';
        }
        return Response() -> Json([
                'data' => [
                    'user' => $this -> transform($user),
                    'message' => $message
                ]
            ], $status_code);
}

    public function destroy($id) {
        log::info("entro a destroy user");
        $user = User::destroy($id);
        if ($user) {
            return Response() -> Json(['message' => 'Todo ocurrió satisfactoriamente'], 200);
        }
        return Response() -> Json(['message' => 'Error al eliminar un usuario'], 400);
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
