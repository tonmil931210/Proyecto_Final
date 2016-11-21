<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;

use Log;
use Illuminate\Http\Response;
use App\Item;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this -> middleware('isAdmin');
    }

    public function index() {
        log::info("entro a index item");
        $items = Item::where('state', '=', 'no eliminado')->get();
        log::info($items);
        return Response() -> Json([
            'data' => [
                'items' => $this -> transformCollection($items)
            ]
        ],200);
    }

    public function show($id) {
        log::info("entro a show item");
        $item = Item::find($id);
        $status_code = 200;
        $message = 'Todo ocurrió satisfactoriamente';
        $previous = '';
        $next = '';
        if ($item) {
            $previous = $this -> SearchingIds($item);
            $next = $this -> SearchingIds($item, '>');
        } else {
            $status_code = 404;
            $message = 'No se encontró el artículo';
        }

        return Response() -> Json([
                'data' => [ 
                    'previous' => $previous,
                    'next' => $next,
                    'item' => $this -> transform($item),
                    'message' => $message
                ]
            ], $status_code);

    }

    public function store(itemRequest $request) {
        log::info("entro a store item");
        $status_code = 200;
        $message = 'Todo ocurrió satisfactoriamente';
        log::info($request);
        $input = $request -> only(['name', 'item_type_id', 'number', 'price', 'reorder', 'min_stock']);
        $item = Item::create($input);
        if (!$item) {
            $status_code = 400;
            $message = 'Problemas para crear un artículo';
        }
        return Response() -> Json([
                    'data' => [
                        'item' => $this -> transform($item),
                        'message' => $message
                    ]
                ], $status_code);
    }

    public function update(itemRequest $request, $id) {
        log::info("entro a update item");
        $status_code = 200;
        $message = 'Todo ocurrió satisfactoriamente';
        $item = Item::find($id);
        $item -> name = $request -> name;
        $item -> item_type_id = $request -> item_type_id;
        $item -> number = $request -> number;
        $item -> price = $request -> price;
        $item -> reorder = $request -> reorder;
        $item -> min_stock = $request -> min_stock;
        $item -> save();
        if (!$item) {
            $status_code = 400;
            $message = 'problemas para actualizar un artículo';
        }
        return Response() -> Json([
                'data' => [
                    'item' => $this -> transform($item),
                    'message' => $message
                ]
            ], $status_code);
	}

    public function destroy($id) {
        log::info("entro a destroy item");
        $item = Item::find($id);
        $item -> state = 'eliminado';
        $item->save();
        if ($item) {
            return Response() -> Json(['message' => 'Todo ocurrió satisfactoriamente'], 200);
        }
        return Response() -> Json(['message' => 'Error al eliminar un artículo'], 400);
    }

    private function transformCollection($items) {
    	return array_map([$this, 'transform'], $items -> toArray());
    }

    private function transform($item) {
    	return [
            'id' => $item['id'],
			'name' => $item['name'],
			'item_type_id' => $item['item_type_id'],
            'number' => $item['number'],
            'number_on_hold' => $item['number_on_hold'],
            'price' => $item['price'],
            'reorder' => $item['reorder'],
            'min_stock' => $item['min_stock'],
    	];
    }

    private function SearchingIds($item, $type_search = '<') {
        $value = Item::where('id', $type_search, $item -> id);
        if ($type_search == '<') {
            return $value -> max('id');
        } 
        return $value -> min('id');
    }
}
