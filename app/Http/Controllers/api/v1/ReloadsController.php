<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ReloadRequest;
use App\Http\Controllers\Controller;
use App\Item;
use App\Reload;
use Log;

class ReloadsController extends Controller
{
    public function __construct()
    {
        $this -> middleware('isAdmin');
    }

    public function recarga(ReloadRequest $request, $id){
    	$status_code = 200;
        $message = 'se recargo satisfactoriamente';
        log::info("entro a reload");
        $item = Item::find($id);
        $item -> number = ($item -> number) + ($request -> number);
        $item -> save();
        Reload::create([                
            'item_id' => $id,
            'number' => $request->number,
        ]);
        return Response() -> Json([
                'data' => [
                    'message' => $message,
                ]
            ], $status_code);
    }
}
