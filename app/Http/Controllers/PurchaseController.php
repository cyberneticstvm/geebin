<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Material;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller implements HasMiddleware
{

    protected $companies, $materials;
    public function __construct()
    {
        $this->companies = Company::where('branch_id', Session::get('branch'))->get();
        $this->materials = Material::where('type', 'material')->get();
    }

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
        $purchases = Purchase::withTrashed()->orderBy('id')->get();
        $materials = $this->materials;
        return view('purchase.index', compact('purchases', 'materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = $this->companies;
        $materials = $this->materials;
        return view('purchase.create', compact('companies', 'materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'company_id' => 'required',
            'supplier_id' => 'required',
            'material_ids' => 'required|exists:materials,id',
            'qty.*' => 'required',
        ]);
        try {
            DB::transaction(function () use ($request) {
                $input = $request->except(array('material_ids', 'qty'));
                $input['created_by'] = $request->user()->id;
                $input['updated_by'] = $request->user()->id;
                $input['branch_id'] = Company::find($request->company_id)->branch_id;
                $purchase = Purchase::create($input);
                $data = [];
                foreach ($request->material_ids as $key => $item):
                    $material = Material::find($item);
                    if ($request->qty[$key] > 0):
                        $data[] = [
                            'purchase_id' => $purchase->id,
                            'material_id' => $item,
                            'qty' => $request->qty[$key],
                            'unit_price' => $material->cost_per_unit,
                            'total' => $request->qty[$key] * $material->cost_per_unit,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    endif;
                endforeach;
                PurchaseDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('purchase.register')->with("success", "Purchase created successfully");
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
        $companies = $this->companies;
        $materials = $this->materials;
        return view('purchase.edit', compact('companies', 'materials', 'purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required|date',
            'company_id' => 'required',
            'supplier_id' => 'required',
            'material_ids' => 'required|exists:materials,id',
            'qty.*' => 'required',
        ]);
        try {
            DB::transaction(function () use ($request, $id) {
                $purchase = Purchase::findOrFail($id);
                $input = $request->except(array('material_ids', 'qty'));
                $input['updated_by'] = $request->user()->id;
                $input['branch_id'] = Company::find($request->company_id)->branch_id;
                $purchase->update($input);
                $data = [];
                foreach ($request->material_ids as $key => $item):
                    $material = Material::find($item);
                    if ($request->qty[$key] > 0):
                        $data[] = [
                            'purchase_id' => $purchase->id,
                            'material_id' => $item,
                            'qty' => $request->qty[$key],
                            'unit_price' => $material->cost_per_unit,
                            'total' => $request->qty[$key] * $material->cost_per_unit,
                            'created_at' => $purchase->created_at,
                            'updated_at' => Carbon::now(),
                        ];
                    endif;
                endforeach;
                PurchaseDetail::where('purchase_id', $id)->delete();
                PurchaseDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('purchase.register')->with("success", "Purchase updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Purchase::findOrFail(decrypt($id))->delete();
        PurchaseDetail::where('purchase_id', decrypt($id))->whereNull('deleted_at')->delete();
        return redirect()->route('purchase.register')->with("success", "Purchase deleted successfully");
    }

    public function restore(string $id)
    {
        $purchase = Purchase::withTrashed()->where('id', decrypt($id))->first();
        PurchaseDetail::withTrashed()->where('purchase_id', decrypt($id))->where('deleted_at', $purchase->deleted_at)->restore();
        $purchase->restore();
        return redirect()->route('purchase.register')->with("success", "Purchase restored successfully");
    }
}
