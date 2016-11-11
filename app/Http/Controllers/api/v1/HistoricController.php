<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Historic;
use Log;
use DB;

class HistoricController extends Controller
{
    public function __construct()
    {
        $this -> middleware('isAdmin');
    }

    public function index() {
        log::info("entro a index historic");
        $historic_all = DB::select(DB::raw("SELECT C1.id, C1.name_item, C1.item_id, C1.created_at, C1.aprobado, C2.cancelado, C3.entregado FROM (SELECT id, name_item, item_id, created_at,sum(number) as aprobado FROM historic WHERE type = 'aprobado' GROUP BY item_id) as C1 LEFT JOIN (SELECT id, name_item, item_id, created_at,sum(number) as cancelado FROM historic WHERE (type = 'cancelado') GROUP BY item_id) as C2 ON C1.item_id = C2.item_id LEFT JOIN (SELECT id, name_item, item_id, created_at,sum(number) as entregado FROM historic WHERE (type = 'entregado') GROUP BY item_id) as C3 ON C3.item_id = C1.item_id"));
        Log::info(json_encode($historic_all));
        return Response() -> Json([
                'data' => [
                    'historic_all' => $historic_all,
                ]
            ], 200);
    }

    public function search(Request $request){
        log::info("entro a search historic");
        $message = "";
        $status_code = 200;
        $historic_all = "";
        if ($request->item_id and $request->date_in and $request->date_end){
            $historic_all = DB::select(DB::raw("SELECT C1.id, C1.name_item, C1.item_id, C1.created_at, C1.aprobado, C2.cancelado, C3.entregado FROM (SELECT id, name_item, item_id, created_at,sum(number) as aprobado FROM historic WHERE type = 'aprobado' GROUP BY item_id) as C1 LEFT JOIN (SELECT id, name_item, item_id, created_at,sum(number) as cancelado FROM historic WHERE (type = 'cancelado') GROUP BY item_id) as C2 ON C1.item_id = C2.item_id LEFT JOIN (SELECT id, name_item, item_id, created_at,sum(number) as entregado FROM historic WHERE (type = 'entregado') GROUP BY item_id) as C3 ON C3.item_id = C1.item_id WHERE C1.created_at >='".$request->date_in."'AND C1.created_at <='".$request->date_end."'AND C1.item_id >='".$request->item_id."'"));
        } else {
           if ($request->item_id) {
                $historic_all = DB::select(DB::raw("SELECT C1.id, C1.name_item, C1.item_id, C1.created_at, C1.aprobado, C2.cancelado, C3.entregado FROM (SELECT id, name_item, item_id, created_at,sum(number) as aprobado FROM historic WHERE type = 'aprobado' GROUP BY item_id) as C1 LEFT JOIN (SELECT id, name_item, item_id, created_at,sum(number) as cancelado FROM historic WHERE (type = 'cancelado') GROUP BY item_id) as C2 ON C1.item_id = C2.item_id LEFT JOIN (SELECT id, name_item, item_id, created_at,sum(number) as entregado FROM historic WHERE (type = 'entregado') GROUP BY item_id) as C3 ON C3.item_id = C1.item_id WHERE C1.item_id >='".$request->item_id."'"));
            } else {
                if ($request->date_in and $request->date_end){
                    $historic_all = DB::select(DB::raw("SELECT C1.id, C1.name_item, C1.item_id, C1.created_at, C1.aprobado, C2.cancelado, C3.entregado FROM (SELECT id, name_item, item_id, created_at,sum(number) as aprobado FROM historic WHERE type = 'aprobado' GROUP BY item_id) as C1 LEFT JOIN (SELECT id, name_item, item_id, created_at,sum(number) as cancelado FROM historic WHERE (type = 'cancelado') GROUP BY item_id) as C2 ON C1.item_id = C2.item_id LEFT JOIN (SELECT id, name_item, item_id, created_at,sum(number) as entregado FROM historic WHERE (type = 'entregado') GROUP BY item_id) as C3 ON C3.item_id = C1.item_id WHERE C1.created_at >='".$request->date_in."'AND C1.created_at <='".$request->date_end."'"));
                } else {
                    if ($request->item_name){
                        $historic_all = DB::select(DB::raw("SELECT C1.id, C1.name_item, C1.item_id, C1.created_at, C1.aprobado, C2.cancelado, C3.entregado FROM (SELECT id, name_item, item_id, created_at,sum(number) as aprobado FROM historic WHERE type = 'aprobado' GROUP BY item_id) as C1 LEFT JOIN (SELECT id, name_item, item_id, created_at,sum(number) as cancelado FROM historic WHERE (type = 'cancelado') GROUP BY item_id) as C2 ON C1.item_id = C2.item_id LEFT JOIN (SELECT id, name_item, item_id, created_at,sum(number) as entregado FROM historic WHERE (type = 'entregado') GROUP BY item_id) as C3 ON C3.item_id = C1.item_id WHERE C1.name_item >='".$request->item_name."'"));
                    } else {
                        $message = "error";
                    }
                }
            } 
        }
        

        return Response() -> Json([
                'data' => [
                    'historic_all' => $historic_all,
                    'message' => $message
                ]
            ], $status_code);
    }


    private function transformCollection($historic) {
        return array_map([$this, 'transform'], $historic);
    }

    private function transform($historic) {
        if ($historic) {
           $one_historic = Historic::find($historic['id']);
           Log::info(json_encode($one_historic));
            return [
                'id' => $historic['id'], 
                'name_item' => $one_historic -> name_item,
                'item_id' => $one_historic -> item_id,
                'date_in' => $one_historic -> created_at->format('Y-m-d'),
                'number' => $one_historic -> number,
                'type' => $one_historic -> type,
            ]; 
        }
        return '';
    }
}
