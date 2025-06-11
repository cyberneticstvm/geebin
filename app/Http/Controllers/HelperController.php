<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Formula;
use App\Models\Material;
use App\Models\ProductionDetails;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Session;

class HelperController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('pending-transfer-list'), only: ['pendingTransferRegister']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('update-production-output'), only: ['updateProductionOutput']),
        ];
    }

    function materialFormula()
    {
        $formula = Formula::all();
        return view('misc.formula', compact('formula'));
    }

    public function pendingTransferRegister()
    {
        $transfers = Transfer::whereIn('to_company_id', Company::where('branch_id', Session::get('branch'))->pluck('id'))->where('approved_status', 'pending')->latest()->get();
        return view('transfer.pending', compact('transfers'));
    }

    public function pendingTransferStatusUpdate(Request $request)
    {
        Transfer::findOrFail($request->transferId)->update([
            'approved_status' => $request->status,
            'approved_by' => $request->user()->id,
            'remarks' => $request->remarks,
        ]);
        return redirect()->back()->with("success", "Transfer status updated successfully");
    }

    public function updateProductionOutput(Request $request)
    {
        $input = $request->all();
        if ($request->type == 'parts'):
            $products = Material::whereIn('type', ['parts', 'material'])->orderBy('id')->get();
        endif;
        if ($request->type == 'mixing'):
            $m = Material::whereIn('type', ['liquid']);
            $products = $m->union(Material::where('id', defaultProductId()))->get();
        endif;
        ProductionDetails::where('production_id', $request->productionId)->where('type', 'in')->forceDelete();
        foreach ($products as $key => $item):
            $name = str_replace(' ', '_', strtolower($item->name));
            ProductionDetails::create([
                'production_id' => $request->productionId,
                'material_id' => $item->id,
                'qty' => $input[$name] ?? 0,
                'type' => 'in',
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        endforeach;
        return redirect()->back()->with("success", "Production output updated successfully");
    }
}
