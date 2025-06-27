<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Extra;
use App\Models\Item;
use App\Models\Production;
use App\Models\ProductionDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller implements HasMiddleware
{
    protected $items, $entities, $create;

    public function __construct(Request $request)
    {
        $type = decrypt($request->route()->parameters['type']);
        $stype = $request->route()->parameters['stype'] ?? 0;
        if ($type == 14):
            $this->items = Item::whereIn('type', [12, 13, 14, 25])->get();
            $this->entities = Entity::whereIn('type_id', [2, 3])->get();
            $this->create = "production.parts.create";
        endif;
        if ($type == 15):
            $this->items = Item::whereIn('type', [15])->get();
            $this->entities = Entity::whereIn('type_id', [4])->get();
            $this->create = "production.bin.create";
        endif;
        if ($type == 20):
            $this->entities = Entity::whereIn('type_id', [2, 3])->get();
            if ($stype == 1):
                $this->items = Item::whereIn('id', [5, 6])->get();
            else:
                $this->items = Item::whereIn('id', [7, 8])->get();
            endif;
            $this->create = "production.decom.create";
        endif;
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
        $type = Extra::findOrFail(decrypt($type));
        $productions = Production::withTrashed()->where('type', $type->id)->latest()->get();
        $items = $this->items;
        return view('production.index', compact('productions', 'type', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type, $stype)
    {
        $type = Extra::findOrFail(decrypt($type));
        $entities = $this->entities;
        $items = $this->items;
        return view($this->create, compact('entities', 'items', 'type', 'stype'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $type)
    {
        $request->validate([
            'production_date' => 'required|date',
            'from_entity' => 'required',
            'to_entity' => 'required',
        ]);
        try {
            $input = $request->except(array('item_ids', 'qty'));
            $input['type'] = $type;
            $input['status'] = 7;
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            DB::transaction(function () use ($request, $input) {
                $purchase = Production::create($input);
                $data = [];
                foreach ($request->item_ids as $key => $item):
                    $data[] = [
                        'production_id' => $purchase->id,
                        'item_id' => $item,
                        'qty' => $request->qty[$key],
                        'type' => 'out',
                        'created_by' => $input['created_by'],
                        'updated_by' => $input['updated_by'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                ProductionDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route("production.register", $type)->with("success", "Production created successfully");
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
        $items = $this->items;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
