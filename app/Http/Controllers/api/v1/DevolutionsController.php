<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\DevolutionRequest;
use App\Http\Controllers\Controller;
use App\Order;
use App\Item;
use App\Order_item;
use App\Devolution;
use Log;

class DevolutionsController extends Controller
{
    public function __construct()
    {
        $this -> middleware('isAdmin');
    }

    public function index() {
        log::info("entro a index devolution");
        $devolutions = Devolution::all();
        return Response() -> Json([
            'data' => [
                'devolutions' => $this -> transformCollection($devolutions)
            ]
        ],200);
    }


    public function devolucion(DevolutionRequest $request, $id){
    	$status_code = 200;
        $message = '';
        $comment = '';
        log::info("entro a Devolution");
        $order_item = Order_item::where('item_id', '=', $request -> item_id)->where('order_id', '=', $id)->first();
        if ($order_item->number < $request->number) {
        	$status_code = 404;
            $message = 'problem with request';
        } else {
        	$order_item->number_return = $order_item->number_return + $request->number;
        	if ($order_item->number < $order_item->number_return) {
        		$status_code = 404;
            	$message = 'problem with request';
        	} else {
        		if ($request -> comment) {
	               $comment = $request -> comment;
		        }
	        	Devolution::create([                
	                        'item_id' => $request -> item_id,
	                        'order_id' => $id,
	                        'number' => $request->number,
	                        'comment' => $comment,
	                    ]);
	        	if ($order_item->number == $order_item->number_return) {
	        		$order_item->state = "entregado";
	        		$message = 'Exitoso';
	        	}
	        	$order_item->save();
                $item = Item::find($request -> item_id);
                $item -> number = $item -> number + $request->number;
                $item -> save();
        	}
        	
        }
        return Response() -> Json([
                'data' => [
                    'message' => $message,
                ]
            ], $status_code);
    }

    public function devolucion_todo(Request $request, $id){
        $status_code = 200;
        $message = '';
        $comment = '';
        log::info("entro a Devolution");
        $order = Order::find($id);
        $items = $order -> items;
        foreach ($items as $one_item){
            $order_item = Order_item::where('item_id', '=', $one_item->id)->where('order_id', '=', $id)->first();
            $order_item->number_return = $order_item->number_return + $order_item->number;
            if ($order_item->number < $order_item->number_return) {
                $status_code = 404;
                $message = 'problem with request';
            } else {
                if ($request -> comment) {
                   $comment = $request -> comment;
                }
                Devolution::create([                
                            'item_id' => $one_item->id,
                            'order_id' => $id,
                            'number' => $order_item->number,
                            'comment' => $comment,
                        ]);
                if ($order_item->number == $order_item->number_return) {
                    $order_item->state = "entregado";
                    $message = 'Exitoso';
                }
                $order_item->save();
                $item = Item::find($request -> item_id);
                $item -> number = $item -> number + $request->number;
                $item -> save();
            }     
            
        }
        return Response() -> Json([
                'data' => [
                    'message' => $message,
                ]
            ], $status_code);
    }

    private function transformCollection($devolution) {
        return array_map([$this, 'transform'], $devolution -> toArray());
    }

    private function transform($devolution) {
        if ($devolution) {
           $one_devolution = Devolution::find($devolution['id']);
            return [
                'id' => $devolution['id'], 
                'order' => $one_devolution -> order,
                'item' => $one_devolution -> item,
                'date_in' => $one_devolution -> created_at->format('Y-m-d'),
                'comment' => $one_devolution -> comment,
                'number' => $one_devolution -> number,
            ]; 
        }
        return '';
    }

}
