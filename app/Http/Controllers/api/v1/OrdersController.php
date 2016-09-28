<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;

use Log;
use Illuminate\Http\Response;
use \Illuminate\Support\Collection;
use App\Order;
use App\Order_item;
use APP\Retornable_order;
use APP\Consumer_order; 

class OrdersController extends Controller
{
    public function __construct()
    {
        $this -> middleware('isAdmin');
    }

    public function index() {
        log::info("entro a index order");
        $orders = Order::all();
        return Response() -> Json([
            'data' => [
                'orders' => $this -> transformCollection($orders)
            ]
        ],200);
    }

    public function show($id) {
        log::info("entro a show order");
        $order = Order::find($id);
        $status_code = 200;
        $message = '';
        $previous = '';
        $next = '';
        if ($order) {
            $previous = $this -> SearchingIds($order);
            $next = $this -> SearchingIds($order, '>');
        } else {
            $status_code = 404;
            $message = 'order does not found';
        }

        return Response() -> Json([
                'data' => [
                    'previous' => $previous,
                    'next' => $next,
                    'order' => $this -> transform($order),
                    'message' => $message
                ]
            ], $status_code);

    }

    public function store(OrderRequest $request) {
        log::info("entro a store order");
        $status_code = 200;
        $message = '';
        $input = $request -> only(['user_id, event_id, order_status_id, date, comments, name_client']);
        log::info($request);
        $order = Order::create($input);
        log::info($order -> event -> id);
        log::info(json_decode($request -> items, true)[0]['id']);
        if ($request -> items){
            foreach (json_decode($request -> items, true) as $item) {
               log::info($item);
               log::info($item['id']);

            }
        }
        log::info('entre2');
        if (!$order) {
            $status_code = 404;
            $message = 'problem with create order';
        }
        return Response() -> Json([
                    'data' => [
                        'order' => $this -> transform($order),
                        'message' => $message
                    ]
                ], $status_code);
    }

    public function update(OrderRequest $request, $id) {
        log::info("entro a update order");
        $status_code = 200;
        $message = '';
        $order = Order::find($id);
        $order -> user_id = $request -> user_id;
        $order -> event_id = $request -> event_id;
        $order -> order_status_id = $request -> order_status_id;
        $order -> date = $request -> date;
        if ($request -> comment) {
            $order -> comment = $request -> comment;
        }
        $order -> save();
        if (!$order) {
            $status_code = 404;
            $message = 'problem with update order';
        }
        return Response() -> Json([
                'data' => [
                    'order' => $this -> transform($order),
                    'message' => $message
                ]
            ], $status_code);
	}

    public function destroy($id) {
        log::info("entro a destroy order");
        Order::destroy($id);
    }

    private function transformCollection($orders) {
    	return array_map([$this, 'transform'], $orders -> toArray());
    }

    private function transform($order) {
    	return [
    		$order['id'] => [
    			'event_name' => $order -> event() -> name,
    			'order_status' => $order -> order_status() -> name,
    			'date_in' => $order -> date,
    			'comment' => $order -> comment,
    			'items' => transformCollectionItems($order -> items()),
    		]
    	];
    }

    private function transformCollectionItems($items) {
    	return array_map([$this, 'transformItem'], $items -> toArray());
    }

    private function transformItem($item) {
    	return [
    		$item['id'] => [
    			'event_name' => $item -> name,
    			'price' => $item -> price,
    			'number' => $item -> number,
    		]
    	];
    }

    private function SearchingIds($order, $type_search = '<') {
        $value = Order::where('id', $type_search, $order -> id);
        if ($type_search == '<') {
            return $value -> max('id');
        } 
        return $value -> min('id');
    }
}
