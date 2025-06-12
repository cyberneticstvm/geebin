<?php

namespace App\Http\Controllers;

use App\Models\Formula;
use App\Models\Material;
use App\Models\Production;
use App\Models\ProductionDetails;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    function validateInventory(Request $request)
    {
        $flag = true;
        $msg = "";
        if ($request->item == 'bin'):
            $parts = Material::where('type', 'parts')->get();
            foreach ($request->items as $key => $item):
                foreach ($parts as $key1 => $part):
                    $formula = Formula::where('part_id', $part->id)->where('bin_id', $item)->first();
                    $stock = getInventory($part->type, $part->id, $request->from_company_id);
                    $availableQty = $stock->sum('balanceQty');
                    $requiredQty = $request->qty[$key] * $formula->qty;
                    if ($availableQty < $requiredQty):
                        $flag = false;
                        $msg .= "Available Qty for {$part->name} is $availableQty but required Qty is $requiredQty<br/>";
                    endif;
                endforeach;
            endforeach;
        else:
            foreach ($request->items as $key => $item):
                $material = Material::find($item);
                $stock = getInventory($request->item, $item, $request->from_company_id);
                $availableQty = $stock->sum('balanceQty');
                if ($availableQty < $request->qty[$key]):
                    $flag = false;
                    $msg .= "Available Qty for {$material->name} is $availableQty <br/>";
                endif;
            endforeach;
        endif;
        if ($flag):
            return response()->json([
                "status" => 'success',
                "stock" => $stock,
            ]);
        else:
            return response()->json([
                "status" => 'error',
                "message" => $msg
            ]);
        endif;
    }

    function getProductionOutput(Request $request)
    {
        $products = ProductionDetails::leftJoin('materials as m', 'm.id', 'production_details.material_id')->selectRaw("m.id, m.name, production_details.qty")->where('production_id', $request->pid)->where('production_details.type', 'in')->whereNull('production_details.deleted_at')->orderBy('material_id')->get();
        return response()->json([
            "status" => 'success',
            "data" => $products,
        ]);
    }

    function validateFormula(Request $request)
    {
        $type = $request->type;
        $input = $request->all();
        if ($type == 'parts'):
            $ppcp_took = 0;
            $ppcp_tot = 0;
            $color_took = 0;
            $color_tot = 0;
            $products = Material::whereIn('type', ['parts'])->orderBy('id')->get();
            //$productsm = Material::whereIn('type', ['material'])->orderBy('id')->get();
            $production = ProductionDetails::where('production_id', $request->productionId)->where('type', 'out')->get();
            foreach ($products as $key => $item):
                $name = str_replace(' ', '_', strtolower($item->name));
                $qty = $input[$name] ?? 0;
                $formula = Formula::where('part_id', $item->id)->first();
                $required_ppcp_for_one = $formula->ppcp / $formula->qty;
                $required_color_for_one = $formula->color / $formula->qty;
                $ppcp_tot += $qty * $required_ppcp_for_one;
                $color_tot += $qty * $required_color_for_one;
            endforeach;
            foreach ($production as $key => $item):
                $name = str_replace(' ', '_', strtolower($item->material->name));
                $qty = $input[$name] ?? 0;
                if ($item->material_id == 1):
                    $ppcp_took = $item->qty;
                    $ppcp_tot += $qty;
                endif;
                if ($item->material_id == 2):
                    $color_took = $item->qty;
                    $color_tot += $qty;
                endif;
            endforeach;
            if (number_format($ppcp_took, 2) != number_format($ppcp_tot, 2) || number_format($color_took, 2) != number_format($color_tot, 2)):
                return response()->json([
                    "status" => 'error',
                    "message" => "Mismatch!<br/>PPCP should be " . number_format($ppcp_took, 2) . " But provided PPCP is " . number_format($ppcp_tot, 2) . "<br/>Color should be " . number_format($color_took, 2) . " But provided Color is " . number_format($color_tot, 2),
                ]);
            else:
                return response()->json([
                    "status" => 'success',
                    "message" => "Okay!",
                ]);
            endif;
        endif;
    }
}
