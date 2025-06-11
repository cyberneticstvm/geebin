<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Material;
use App\Models\Production;
use App\Models\ProductionDetails;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller implements HasMiddleware
{
    protected $materials, $company;
    public function __construct(Request $request)
    {
        $type = $request->route()->parameters['type'];
        if ($type == 'parts'):
            $this->materials = Material::where('type', 'material')->get();
        else:
            $m = Material::whereIn('type', ['liquid']);
            $this->materials = $m->union(Material::where('id', defaultProductId()))->get();
        endif;
        $this->company = Company::where('branch_id', Session::get('branch'))->where('type_id', 2)->pluck('name', 'id');
    }

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('production-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('production-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('production-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('production-delete'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('production-restore'), only: ['restore']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index($type)
    {
        $materials = $this->materials;
        $products = Material::where('type', 'parts')->orderBy('id')->get();
        $productions = Production::withTrashed()->where('type', $type)->where('branch_id', Session::get('branch'))->latest()->get();
        return view('production.index', compact('productions', 'materials', 'products', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type)
    {
        $materials = $this->materials;
        $companies = $this->company;
        return view('production.create', compact('materials', 'companies', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $type)
    {
        $request->validate([
            'date' => 'required|date',
            'from_company_id' => 'required',
        ]);
        try {
            DB::transaction(function () use ($request, $type) {
                $input = $request->except(array('items', 'qty', 'from_company_id'));
                $input['created_by'] = $request->user()->id;
                $input['updated_by'] = $request->user()->id;
                $input['branch_id'] = Session::get('branch');
                $input['type'] = $type;
                $input['company_id'] = $request->from_company_id;
                $production = Production::create($input);
                $data = [];
                foreach ($request->items as $key => $item):
                    if ($request->qty[$key] > 0):
                        $data[] = [
                            'production_id' => $production->id,
                            'material_id' => $item,
                            'qty' => $request->qty[$key],
                            'type' => 'out',
                            'created_by' => $request->user()->id,
                            'updated_by' => $request->user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    endif;
                endforeach;
                ProductionDetails::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('production.register', $type)->with("success", "Production created successfully");
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
    public function edit(string $type, string $id)
    {
        try {
            $production = Production::findOrFail(decrypt($id));
            if ($production->details()->where('type', 'in')->exists()):
                throw new Exception("User not allowed to edit this record at the moment");
            endif;
            $materials = $this->materials;
            $companies = $this->company;
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }

        return view('production.edit', compact('production', 'materials', 'companies', 'type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $type, string $id)
    {
        $request->validate([
            'date' => 'required|date',
            'from_company_id' => 'required',
        ]);
        try {
            $production = Production::findOrFail($id);
            DB::transaction(function () use ($request, $production) {
                $input = $request->except(array('items', 'qty', 'from_company_id'));
                $input['updated_by'] = $request->user()->id;
                $input['branch_id'] = Session::get('branch');
                $input['company_id'] = $request->from_company_id;
                $production->update($input);
                $data = [];
                foreach ($request->items as $key => $item):
                    if ($request->qty[$key] > 0):
                        $data[] = [
                            'production_id' => $production->id,
                            'material_id' => $item,
                            'qty' => $request->qty[$key],
                            'type' => 'out',
                            'created_by' => $request->user()->id,
                            'updated_by' => $request->user()->id,
                            'created_at' => $production->created_at,
                            'updated_at' => Carbon::now(),
                        ];
                    endif;
                endforeach;
                ProductionDetails::where('production_id', $production->id)->where('type', 'out')->delete();
                ProductionDetails::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('production.register', $type)->with("success", "Production updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $type, string $id)
    {
        try {
            $production = Production::where('id', decrypt($id))->firstOrFail();
            if ($production->details()->where('type', 'in')->exists()):
                throw new Exception("User not allowed to delete this record at the moment");
            endif;
            $production->delete();
            ProductionDetails::where('production_id', decrypt($id))->where('type', 'out')->whereNull('deleted_at')->delete();
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
        return redirect()->route('production.register', $type)->with("success", "Production deleted successfully");
    }

    public function restore(string $type, string $id)
    {
        $production = Production::withTrashed()->where('id', decrypt($id))->first();
        ProductionDetails::withTrashed()->where('production_id', decrypt($id))->where('type', 'out')->where('deleted_at', $production->deleted_at)->restore();
        $production->restore();
        return redirect()->route('production.register', $type)->with("success", "Production restored successfully");
    }
}
