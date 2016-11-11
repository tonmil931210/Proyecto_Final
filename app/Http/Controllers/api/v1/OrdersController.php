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
use App\Historic;
use Mail;
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
        $status_code = 200;
        $message = '';
        log::info("entro a store order");
        log::info($request);
        $order = false;
        if ($this->verifyItems($request -> items)) {
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
            if (!$order) {
                $status_code = 404;
                $message = 'problem with request';
            }
        } else {
            $status_code = 404;
            $message = 'problem with request (items)';
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
        if ($request -> items){
            foreach (json_decode($request -> items, true) as $item) {
                $order_item = Order_item::where('item_id', '=', $item['id'])->where('order_id', '=', $order->id)->first();
                log::info($order_item);
                if ($order_item) {
                    $order_item -> number = $item['number'];
                    $order_item -> date = $item['date'];
                    $order_item -> save();
                } else {
                    Order_item::create([                
                        'item_id' => $item['id'],
                        'order_id' => $order -> id,
                        'number' => $item['number'],
                        'date' => $item['date'],
                    ]);
                }
                
            }
            $items = $order -> items;
            foreach ($items as $item) {
                $exist = false;
                foreach (json_decode($request -> items, true) as $new_item) {
                   if ($item -> id == $new_item['id']) {
                        $exist = true;
                   } 
                }
                if ($exist == false) {
                    $order_item = Order_item::where('item_id', '=', $item->id)->where('order_id', '=', $order->id)->first();
                    Order_item::destroy($order_item->id);
                }
                
            }
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
        $order = Order::destroy($id);
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
        $status_code = 200;
        $message = '';
        log::info('1');
        $statusOrder = Order_status::where('name', '=', 'Aprobado')->first();
        log::info('2');
        $order = Order::find($id);
        if ($this->addNumerOnHold($order, "wait")) {
            $order -> order_status_id = $statusOrder -> id;
            $order -> save();
            if (!$order) {
                $status_code = 404;
                $message = 'problem with request';
            } else {
                $this->addHistoric($order->items, 'aprobado');
            }
        } else {
            $status_code = 404;
            $message = 'problem with request (items)';
        }
        log::info('aprobar');
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
        $this->addNumerOnHold($order);
        $status_code = 200;
        $message = '';
        if (!$order) {
            $status_code = 404;
            $message = 'problem with request';
        } else {
            $this->addHistoric($order->items, 'entregado');
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
        $this->addNumerOnHold($order, "less");
        $status_code = 200;
        $message = '';
        if (!$order) {
            $status_code = 404;
            $message = 'problem with request';
        } else {
           $this->addHistoric($order->items, 'cancelado');
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
        if ($order) {
           $one_order = Order::find($order['id']);
            return [
                'id' => $order['id'], 
                'event_id' => $one_order -> event_id,
                'event_name' => $one_order -> event -> name,
                'order_status' => $one_order -> order_status -> name,
                'date_in' => $one_order -> created_at->format('Y-m-d'),
                'name_client' => $one_order -> name_client,
                'type' => $one_order -> type,
                'comment' => $one_order -> comment,
                'items' => $one_order -> items,
            ]; 
        }
        return '';
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

    private function addNumerOnHold($order, $type = "add") {
        log::info("addnumber");
        $data = "";
        $value = true;
        $items = $order->items;
        foreach ($items as $item) {
            $one_item = Item::find($item['id']);
            log::info($one_item);
            if ($type == "wait") {
                $number_on_hold = $one_item->number_on_hold + $item['pivot']['number'];
                log::info($number_on_hold);
                if ($number_on_hold <= $one_item->number) {
                    $one_item->number_on_hold = $number_on_hold;
                    $one_item->save();
                } else {
                    $value = false;
                    break;
                }
            } else {
                if ($type == "add"){
                    $one_item->number_on_hold =  $one_item->number_on_hold - $item['pivot']['number'];
                    $one_item->number =  $one_item->number - $item['pivot']['number'];
                    $one_item->save();
                    $this->updatePivot($order, $one_item, $item['pivot']['number']);
                    if ($one_item->number <= $one_item->min_stock){
                        $data = $data . "min stock" . $one_item->name . $one_item->id . "-" . $one_item->number . "-";
                        log::info("INFORMACION PARA EL CORREO - min stock");
                        log::info($data);
                    } else {
                        if ($one_item->number <= $one_item->reorder){
                            $data = $data . "reorder" . $one_item->name . $one_item->id . "-" . $one_item->number . "-";
                            log::info("INFORMACION PARA EL CORREO - reorder");
                            log::info($data);
                        } 
                    }
                } else {
                    $one_item->number_on_hold =  $one_item->number_on_hold - $item['pivot']['number'];
                    $one_item->save();
                }
            }
            
        }
        log::info("INFORMACION PARA EL CORREO");
        log::info($data);
        $this->sendEmail($data, "");
        return $value;
    }

    private function verifyItems($items) {
        $status = true;
        foreach (json_decode($items, true) as $item) {
           $one_item = Item::find($item['id']);
           if ($one_item) {
               if ($one_item->number < $item['number']) {
                    $status = false;
                    break;
               }
            } else {
                $status = false;
                break;
            }
        }
        return $status;
    }

    private function addHistoric($items, $type){
        Log::info("addHistoric");
        foreach ($items as $item) {
            Log::info($item);
            Log::info($item->id);
            Historic::create(['name_item' => $item->name, 'item_id' => $item->id, 'number' => $item->pivot->number, 'type' => $type]);
           
        }
    }

    private function sendEmail($body, $email){
        if ($body <> ""){
            $message = ['data' => $body];
            Mail::send('emails.message', $message, function($message)
           {
               //asunto
               $message->subject("test");
     
               //receptor
               $message->to("mcasanova@uninorte.edu.co");
     
           });
        }  
    }

    private function updatePivot($order, $item, $number_return){
        $order_item = Order_item::where('item_id', '=', $item->id)->where('order_id', '=', $order->id)->first();    
        $order_item->number_return = $number_return;
        if ($number_return = $order_item->number) {
             $order_item->state = "entregado";
        }
        $order_item->save();
    }
}
