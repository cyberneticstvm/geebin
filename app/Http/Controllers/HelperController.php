<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Production;
use App\Models\ProductionDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HelperController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('item-list'), only: ['items']),
        ];
    }

    function items()
    {
        $items = Item::all();
        return view('item.index', compact('items'));
    }

    function saveProductionMaterial(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'qty' => 'required',
        ]);
        try {
            $production = Production::where('status', 7)->where('id', decrypt($request->pid))->firstOrFail();
            ProductionDetail::create([
                'production_id' => $production->id,
                'item_id' => $request->item_id,
                'qty' => $request->qty,
                'type' => 'out',
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route("production.register", ['type' => encrypt($production->type), 'stype' => 0])->with("success", "Material added successfully");
    }

    function saveProductionParts(Request $request)
    {
        try {
            $production = Production::where('status', 7)->where('id', decrypt($request->pid))->firstOrFail();
            $items = Item::whereIn('type', [14, 25])->get();
            $input = $request->all();
            $data = [];
            foreach ($items as $key => $item):
                $iname = str_replace(' ', '_', $item->name);
                if ($input[$iname] > 0):
                    $data[] = [
                        'production_id' => $production->id,
                        'item_id' => $item->id,
                        'qty' => $input[$iname],
                        'type' => 'in',
                        'created_by' => $request->user()->id,
                        'updated_by' => $request->user()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endif;
            endforeach;
            if ($data) ProductionDetail::insert($data);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route("production.register", ['type' => encrypt($production->type), 'stype' => 0])->with("success", "Production updated successfully");
    }

    function saveProductionDecom(Request $request)
    {
        try {
            $production = Production::where('status', 7)->where('id', decrypt($request->pid))->firstOrFail();
            $items = Item::whereIn('type', [20])->get();
            $input = $request->all();
            $data = [];
            foreach ($items as $key => $item):
                $iname = str_replace(' ', '_', $item->name);
                if ($input[$iname] > 0):
                    $data[] = [
                        'production_id' => $production->id,
                        'item_id' => $item->id,
                        'qty' => $input[$iname],
                        'type' => 'in',
                        'created_by' => $request->user()->id,
                        'updated_by' => $request->user()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endif;
            endforeach;
            if ($data) ProductionDetail::insert($data);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route("production.register", ['type' => encrypt($production->type), 'stype' => 0])->with("success", "Production updated successfully");
    }
}
