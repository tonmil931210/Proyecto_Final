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
        $message = 'Todo ocurrió satisfactoriamente';
        $comment = '';
        log::info("entro a Devolution");
        $order_item = Order_item::where('item_id', '=', $request -> item_id)->where('order_id', '=', $id)->first();
        if ($order_item->number < $request->number) {
        	$status_code = 400;
            $message = 'El valor que va a devolver es mayor al que presto';
        } else {
        	$order_item->number_return = $order_item->number_return + $request->number;
        	if ($order_item->number < $order_item->number_return) {
        		$status_code = 400;
            	$message = 'Está devolviendo un número de artículos de mas';
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
	        	}
	        	$order_item->save();
                log::info($request -> item_id);
                $item = Item::find($request -> item_id);
                log::info($item);
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
        log::info("entro a Devolution");
        $status_code = 200;
        $message = 'Ocurrio algun error';
        $comment = '';
        $order = Order::find($id);
        $items = $order -> items;
        foreach ($items as $one_item){
            $order_item = Order_item::where('item_id', '=', $one_item->id)->where('order_id', '=', $id)->first();
            $number = ($order_item->number - $order_item->number_return);
            $order_item->number_return = $order_item->number_return + $number;
            if ($request -> comment) {
               $comment = $request -> comment;
            }
            Devolution::create([                
                        'item_id' => $one_item->id,
                        'order_id' => $id,
                        'number' => $number,
                        'comment' => $comment,
                    ]);
            if ($order_item->number == $order_item->number_return) {
                $order_item->state = "entregado";
            }
            $order_item->save();
            $item = Item::find($one_item->id);
            $item -> number = $item -> number + $number;
            $item -> save();
            $message = 'Todo ocurrió satisfactoriamente';   
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
