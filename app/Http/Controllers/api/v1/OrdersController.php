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
use App\Retornable_order;
use App\Consumer_order; 
use App\Item;
use App\Order_status;

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
            $previous = $this -> searchingIds($order);
            $next = $this -> searchingIds($order, '>');
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
        log::info($request);
        $order = Order::create($request -> toArray());
        if ($request -> items){
            foreach (json_decode($request -> items, true) as $item) {
               Order_item::create([                
                    'item_id' => $item['id'],
                    'order_id' => $order -> id,
                    'number' => $item['number'],
                    'date' => $item['date'],
                ]);

            }
        }
        $status_code = 200;
        $message = '';
        if (!$order) {
            $status_code = 404;
            $message = 'problem with request';
        }
        return Response() -> Json([
                'data' => [
                    'order' => $this -> transform($order),
                    'message' => $message,
                ]
            ], $status_code);
    }

    public function update(OrderRequest $request, $id) {
        log::info("entro a update order");
        $order = Order::find($id);
        $order -> name_client = $request -> name_client;
        $order -> event_id = $request -> event_id;
        if ($request -> comment) {
            $order -> comment = $request -> comment;
        }
        $order -> save();
        $status_code = 200;
        $message = '';
        if (!$order) {
            $status_code = 404;
            $message = 'problem with request';
        }
        return Response() -> Json([
                'data' => [
                    'order' => $this -> transform($order),
                    'message' => $message,
                ]
            ], $status_code);
	}

    public function destroy($id) {
        log::info("entro a destroy order");
        Order::destroy($id);
    }

    public function searchStatusOrder(Request $request){
        log::info("entro a searchStatusOrder");
        log::info($request);
        $orders = Order::where('order_status_id', '=', $request->status_id)->get();
        return Response() -> Json([
            'data' => [
                'orders' => $this -> transformCollection($orders)
            ]
        ],200);
    }


    public function aprobar($id){
        log::info('1');
        $statusOrder = Order_status::where('name', '=', 'Aprobado')->first();
        log::info('2');
        $order = Order::find($id);
        $order -> order_status_id = $statusOrder -> id;
        $order -> save();
        $status_code = 200;
        $message = '';
        if (!$order) {
            $status_code = 404;
            $message = 'problem with request';
        }
        return Response() -> Json([
                'data' => [
                    'order' => $this -> transform($order),
                    'message' => $message,
                ]
            ], $status_code);
    }

    public function entregar($id){
        $statusOrder = Order_status::where('name', '=', 'Entregado')->first();
        $order = Order::find($id);
        $order -> order_status_id = $statusOrder->id;
        $order -> save();
        $status_code = 200;
        $message = '';
        if (!$order) {
            $status_code = 404;
            $message = 'problem with request';
        }
        return Response() -> Json([
                'data' => [
                    'order' => $this -> transform($order),
                    'message' => $message,
                ]
            ], $status_code);

    }
    public function cancelar($id){
        $statusOrder = Order_status::where('name', '=', 'Cancelado')->first();
        $order = Order::find($id);
        $order -> order_status_id = $statusOrder->id;
        $order -> save();
        $status_code = 200;
        $message = '';
        if (!$order) {
            $status_code = 404;
            $message = 'problem with request';
        }
        return Response() -> Json([
                'data' => [
                    'order' => $this -> transform($order),
                    'message' => $message,
                ]
            ], $status_code);

    }
    public function rechazar($id){
        $statusOrder = Order_status::where('name', '=', 'Rechazado')->first();
        $order = Order::find($id);
        $order -> order_status_id = $statusOrder->id;
        $order -> save();
        $status_code = 200;
        $message = '';
        if (!$order) {
            $status_code = 404;
            $message = 'problem with request';
        }
        return Response() -> Json([
                'data' => [
                    'order' => $this -> transform($order),
                    'message' => $message,
                ]
            ], $status_code);

    }
    public function pendiente($id){
        $statusOrder = Order_status::where('name', '=', 'Pendiente')->first();
        $order = Order::find($id);
        $order -> order_status_id = $statusOrder->id;
        $order -> save();
        $status_code = 200;
        $message = '';
        if (!$order) {
            $status_code = 404;
            $message = 'problem with request';
        }
        return Response() -> Json([
                'data' => [
                    'order' => $this -> transform($order),
                    'message' => $message,
                ]
            ], $status_code);

    }

    private function returnOrder($order){
        log::info("returnOrder");
        $status_code = 200;
        $message = '';
        if (!$order) {
            $status_code = 404;
            $message = 'problem with request';
        }
        return Response() -> Json([
                'data' => [
                    'order' => $this -> transform($order),
                    'message' => $message,
                ]
            ], $status_code);
    }
    private function transformCollection($orders) {
    	return array_map([$this, 'transform'], $orders -> toArray());
    }

    private function transform($order) {
        $one_order = Order::find($order['id']);
    	return [
            'id' => $order['id'], 
			'event_name' => $one_order -> event -> name,
			'order_status' => $one_order -> order_status -> name,
			'date_in' => $one_order -> created_at->format('Y-m-d') ,
            'name_client' => $one_order -> name_client,
			'comment' => $one_order -> comment,
			'items' => $one_order -> items,
    	];
    }

    private function transformCollectionItems($items) {
    	return array_map([$this, 'transformItem'], $items -> toArray());
    }

    private function transformItem($item) {
        #$one_item = Item::find($item['id']);
    	return [
            'id' => $item['id'],
			#'event_name' => $one_item -> name,
			#'price' => $one_item -> price,
			#'number' => $one_item -> number,
    	];
    }

    private function searchingIds($order, $type_search = '<') {
        $value = Order::where('id', $type_search, $order -> id);
        if ($type_search == '<') {
            return $value -> max('id');
        } 
        return $value -> min('id');
    }
}
