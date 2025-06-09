<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    function validateInventory(Request $request)
    {
        $stock = getInventory($request->item, $request->items[0], $request->from_company_id);
        $availableQty = $stock->sum('purchasedQty');
        if ($availableQty > $request->qty[0]):
            return response()->json([
                "stock" => $stock,
                "status" => 'success',
            ]);
        else:
            return response()->json([
                "stock" => $stock,
                "status" => 'error'
            ]);
        endif;
    }
}
