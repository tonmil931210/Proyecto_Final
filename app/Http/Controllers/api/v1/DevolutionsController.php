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
        	}
        	
        }
        return Response() -> Json([
                'data' => [
                    'message' => $message,
                ]
            ], $status_code);
    }
}
