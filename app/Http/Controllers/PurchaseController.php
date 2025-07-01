<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('purchase-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('purchase-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('purchase-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('purchase-delete'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('purchase-restore'), only: ['restore']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::withTrashed()->latest()->get();
        return view('purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entities = Entity::where('id', 1)->pluck('name', 'id');
        $items = Item::whereIn('type', [12, 13, 16, 17, 18])->pluck('name', 'id');
        return view('purchase.create', compact('entities', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'purchase_date' => 'required|date',
            'entity_id' => 'required',
        ]);
        try {
            $input = $request->except(array('item_ids', 'qty'));
            DB::transaction(function () use ($request, $input) {
                $input['created_by'] = $request->user()->id;
                $input['updated_by'] = $request->user()->id;
                $purchase = Purchase::create($input);
                $data = [];
                foreach ($request->item_ids as $key => $item):
                    $data[] = [
                        'purchase_id' => $purchase->id,
                        'item_id' => $item,
                        'qty' => $request->qty[$key],
                    ];
                endforeach;
                PurchaseDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route("purchase.register")->with("success", "Purchase created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $purchase = Purchase::findOrFail(decrypt($id));
        $entities = Entity::where('id', 1)->pluck('name', 'id');
        $items = Item::whereIn('type', [12, 13, 16, 17, 18])->pluck('name', 'id');
        return view('purchase.edit', compact('entities', 'items', 'purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'purchase_date' => 'required|date',
            'entity_id' => 'required',
        ]);
        $purchase = Purchase::findOrFail($id);
        try {
            $input = $request->except(array('item_ids', 'qty'));
            DB::transaction(function () use ($request, $input, $purchase) {
                $input['updated_by'] = $request->user()->id;
                $data = [];
                foreach ($request->item_ids as $key => $item):
                    $data[] = [
                        'purchase_id' => $purchase->id,
                        'item_id' => $item,
                        'qty' => $request->qty[$key],
                    ];
                endforeach;
                PurchaseDetail::where('purchase_id', $purchase->id)->delete();
                PurchaseDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route("purchase.register")->with("success", "Purchase updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Purchase::findOrFail(decrypt($id))->delete();
        return redirect()->route("purchase.register")->with("success", "Purchase deleted successfully");
    }
}
