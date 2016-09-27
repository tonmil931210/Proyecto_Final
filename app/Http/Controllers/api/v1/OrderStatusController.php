<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStatusRequest;

use Log;
use Illuminate\Http\Response;
use App\Order_status;

class OrderStatusController extends Controller
{
    public function __construct()
    {
        $this -> middleware('isAdmin');
    }

    public function index() {
        log::info("entro a index OrderStatus");
        $order_status = Order_status::all();
        return Response() -> Json([
            'data' => [
                'order_status' => $this -> transformCollection($order_status)
            ]
        ],200);
    }

    public function show($id) {
        log::info("entro a show OrderStatus");
        $order_status = Order_status::find($id);
        $status_code = 200;
        $message = '';
        $previous = '';
        $next = '';
        if ($order_status) {
            $previous = $this -> SearchingIds($order_status);
            $next = $this -> SearchingIds($order_status, '>');
        } else {
            $status_code = 404;
            $message = 'order_status does not found';
        }

        return Response() -> Json([
                'data' => [
                    'previous' => $previous,
                    'next' => $next,
                    'order_status' => $this -> transform($order_status),
                    'message' => $message
                ]
            ], $status_code);

    }

    public function store(OrderStatusRequest $request) {
        log::info("entro a store OrderStatus");
        $status_code = 200;
        $message = '';
        $input = $request -> only(['name']);
        log::info($input);
        $order_status = Order_status::create($input);
        if (!$order_status) {
            $status_code = 404;
            $message = 'problem with create order_status';
        }
        return Response() -> Json([
                    'data' => [
                        'order_status' => $this -> transform($order_status),
                        'message' => $message
                    ]
                ], $status_code);
    }

    public function update(OrderStatusRequest $request, $id) {
        log::info("entro a update OrderStatus");
        $status_code = 200;
        $message = '';
        $order_status = Order_status::find($id);
        $order_status -> name = $request -> name;
        $order_status -> save();
        if (!$order_status) {
            $status_code = 404;
            $message = 'problem with update order_status';
        }
        return Response() -> Json([
                'data' => [
                    'order_status' => $this -> transform($order_status),
                    'message' => $message
                ]
            ], $status_code);
	}

    public function destroy($id) {
        log::info("entro a destroy OrderStatus");
        $order_status = Order_status::destroy($id);
        if ($order_status) {
            return Response() -> Json(['message' => 'ok'], 200);
        }
        return Response() -> Json(['message' => 'error'], 400);
    }

    private function transformCollection($order_status) {
    	return array_map([$this, 'transform'], $order_status -> toArray());
    }

    private function transform($order_status) {
    	return [
            'id' => $order_status['id'], 
			'name' => $order_status['name'],
    	];
    }

    private function SearchingIds($order_status, $type_search = '<') {
        $value = Order_status::where('id', $type_search, $order_status -> id);
        if ($type_search == '<') {
            return $value -> max('id');
        } 
        return $value -> min('id');
    }
}
