<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Extra;
use App\Models\Formula;
use App\Models\Material;
use App\Models\Transfer;
use App\Models\TransferDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransferController extends Controller implements HasMiddleware
{

    protected $products, $fromCompany, $toCompany;
    public function __construct(Request $request)
    {
        $type = $request->route()->parameters['item'];
        $this->products = Material::where('type', $type)->pluck('name', 'id');
        if ($type == 'material'):
            $this->fromCompany = Company::where('branch_id', Session::get('branch'))->where('type_id', 5)->pluck('name', 'id');
            $this->toCompany = Company::where('branch_id', Session::get('branch'))->where('type_id', 5)->pluck('name', 'id');
        endif;
        if ($type == 'parts'):
            $this->fromCompany = Company::where('branch_id', Session::get('branch'))->where('type_id', 5)->pluck('name', 'id');
            $this->toCompany = Company::where('branch_id', Session::get('branch'))->where('type_id', 15)->pluck('name', 'id');
        endif;
        if ($type == 'product'):
            $this->fromCompany = Company::where('branch_id', Session::get('branch'))->where('type_id', 15)->pluck('name', 'id');
            $this->toCompany = Company::where('branch_id', Session::get('branch'))->where('type_id', 6)->pluck('name', 'id');
        endif;
    }

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('transfer-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('transfer-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('transfer-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('transfer-delete'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('transfer-restore'), only: ['restore']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index($item)
    {
        $transfers = Transfer::withTrashed()->where('item', $item)->where('branch_id', Session::get('branch'))->latest()->get();
        return view('transfer.index', compact('transfers', 'item'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($item)
    {
        $fromCompany = $this->fromCompany;
        $toCompany = $this->toCompany;
        $products = $this->products;
        return view('transfer.create', compact('fromCompany', 'toCompany', 'products', 'item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $item)
    {
        $request->validate([
            'date' => 'required|date',
            'from_company_id' => 'required',
            'to_company_id' => 'required|different:from_company_id',
            'item.*' => 'required',
            'qty.*' => 'required'
        ]);
        try {
            DB::transaction(function () use ($request, $item) {
                $input = $request->except(array('items', 'qty'));
                $input['created_by'] = $request->user()->id;
                $input['updated_by'] = $request->user()->id;
                $input['branch_id'] = Session::get('branch');
                $input['item'] = $item;
                $input['approved_status'] = 'pending';
                $transfer = Transfer::create($input);
                $data = [];
                foreach ($request->items as $key => $item):
                    if ($request->qty[$key] > 0):
                        $data[] = [
                            'transfer_id' => $transfer->id,
                            'item' => $item,
                            'qty' => $request->qty[$key],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    endif;
                endforeach;
                TransferDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('transfer.register', $item)->with("success", "Transfer created successfully");
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
    public function edit(string $item, string $id)
    {
        $transfer = Transfer::findOrFail(decrypt($id));
        $fromCompany = $this->fromCompany;
        $toCompany = $this->toCompany;
        $products = $this->products;
        return view('transfer.edit', compact('transfer', 'fromCompany', 'toCompany', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $item, string $id)
    {
        $request->validate([
            'date' => 'required|date',
            'from_company_id' => 'required',
            'to_company_id' => 'required|different:from_company_id',
            'item.*' => 'required',
            'qty.*' => 'required'
        ]);
        try {
            $transfer = Transfer::findOrFail($id);
            DB::transaction(function () use ($request, $transfer) {
                $input = $request->except(array('items', 'qty'));
                $input['updated_by'] = $request->user()->id;
                $input['branch_id'] = Session::get('branch');
                $input['approved_status'] = 'pending';
                $transfer->update($input);
                $data = [];
                foreach ($request->items as $key => $item):
                    if ($request->qty[$key] > 0):
                        $data[] = [
                            'transfer_id' => $transfer->id,
                            'item' => $item,
                            'qty' => $request->qty[$key],
                            'created_at' => $transfer->created_at,
                            'updated_at' => Carbon::now(),
                        ];
                    endif;
                endforeach;
                TransferDetail::where('transfer_id', $transfer->id)->delete();
                TransferDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('transfer.register', $transfer->item)->with("success", "Transfer updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $item, string $id)
    {
        $transfer = Transfer::findOrFail(decrypt($id));
        $transfer->delete();
        TransferDetail::where('transfer_id', decrypt($id))->whereNull('deleted_at')->delete();
        return redirect()->route('transfer.register', $item)->with("success", "Transfer deleted successfully");
    }

    public function restore(string $item, string $id)
    {
        $transfer = Transfer::withTrashed()->where('id', decrypt($id))->first();
        TransferDetail::withTrashed()->where('transfer_id', decrypt($id))->where('deleted_at', $transfer->deleted_at)->restore();
        $transfer->restore();
        return redirect()->route('transfer.register', $item)->with("success", "Transfer restored successfully");
    }
}
