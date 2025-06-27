<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\ProductionDetail;
use App\Models\ProductionDetails;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    function getMaterialDetails(string $pid)
    {
        $production = Production::findOrFail(decrypt($pid));
        $op = "";
        foreach ($production->details->whereIn('item_id', [1, 2, 3, 4]) as $key => $pro):
            $op .= "<tr>";
            $op .= "<td>" . $key + 1 . "</td>";
            $op .= "<td>" . $pro->item->name . "</td>";
            $op .= "<td>" . $pro->qty . "</td>";
            $op .= "</tr>";
        endforeach;
        echo $op;
    }

    function getProductionDetails(string $pid)
    {
        $production = ProductionDetail::leftJoin('productions as p', 'p.id', 'production_details.production_id')->whereIn("production_details.item_id", [11, 12, 13, 14, 15, 16, 17, 22])->where('p.id', decrypt($pid))->selectRaw("production_details.item_id, SUM(production_details.qty) AS qty")->groupBy("item_id")->get();
        $op = "";
        foreach ($production as $key => $pro):
            $op .= "<tr>";
            $op .= "<td>" . $key + 1 . "</td>";
            $op .= "<td>" . $pro->item->name . "</td>";
            $op .= "<td>" . $pro->qty . "</td>";
            $op .= "</tr>";
        endforeach;
        echo $op;
    }
}
