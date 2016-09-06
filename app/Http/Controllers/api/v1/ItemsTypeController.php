<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemTypeRequest;

use Log;
use Illuminate\Http\Response;
use App\Item_type;

class ItemsTypeController extends Controller
{
    public function __construct()
    {
        $this -> middleware('isAdmin');
    }

    public function index() {
        $item_types = Item_type::all();
        return Response() -> Json([
            'data' => [
                'item_types' => $this -> transformCollection($item_types)
            ]
        ],200);
    }

    public function show($id) {
        $item_type = Item_type::find($id);
        $status_code = 200;
        $message = '';
        $previous = '';
        $next = '';
        if ($item_type) {
            $previous = $this -> SearchingIds($item_type);
            $next = $this -> SearchingIds($item_type, '>');
        } else {
            $status_code = 404;
            $message = 'item_type does not found';
        }

        return Response() -> Json([
                'data' => [
                    'previous' => $previous,
                    'next' => $next,
                    'item_type' => $this -> transform($item_type),
                    'message' => $message
                ]
            ], $status_code);

    }

    public function store(ItemTypeRequest $request) {
        $status_code = 200;
        $message = '';
        $input = $request -> only(['name']);
        log::info($input);
        $item_type = Item_type::create($input);
        log::info('entre2');
        if (!$item_type) {
            $status_code = 404;
            $message = 'problem with create item_type';
        }
        return Response() -> Json([
                    'data' => [
                        'item_type' => $this -> transform($item_type),
                        'message' => $message
                    ]
                ], $status_code);
    }

    public function update(ItemTypeRequest $request, $id) {
        $status_code = 200;
        $message = '';
        $item_type = Item_type::find($id);
        $item_type -> name = $request -> name;
        $item_type -> save();
        if (!$item_type) {
            $status_code = 404;
            $message = 'problem with update item_type';
        }
        return Response() -> Json([
                'data' => [
                    'item_type' => $this -> transform($item_type),
                    'message' => $message
                ]
            ], $status_code);
}

    public function destroy($id) {
        $item_type = Item_type::destroy($id);
        if ($item_type) {
            return Response() -> Json(['message' => 'ok'], 200);
        }
        return Response() -> Json(['message' => 'error'], 400);
    }

    private function transformCollection($item_types) {
    	return array_map([$this, 'transform'], $item_types -> toArray());
    }

    private function transform($item_type) {
    	return [
            'id' => $item_type['id'],
			'name' => $item_type['name'],
    	];
    }

    private function SearchingIds($item_type, $type_search = '<') {
        $value = Item_type::where('id', $type_search, $item_type -> id);
        if ($type_search == '<') {
            return $value -> max('id');
        } 
        return $value -> min('id');
    }
}
