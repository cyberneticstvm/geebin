<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    function validateInventory(Request $request)
    {
        $flag = true;
        $msg = "";
        foreach ($request->items as $key => $item):
            $material = Material::find($item);
            $stock = getInventory($request->item, $item, $request->from_company_id);
            $availableQty = $stock->sum('balanceQty');
            if ($availableQty < $request->qty[$key]):
                $flag = false;
                $msg .= "Available Qty for {$material->name} is $availableQty <br/>";
            endif;
        endforeach;
        if ($flag):
            return response()->json([
                "status" => 'success',
                "stock" => $stock,
            ]);
        else:
            return response()->json([
                "stock" => $stock,
                "status" => 'error',
                "message" => $msg
            ]);
        endif;
    }
}
