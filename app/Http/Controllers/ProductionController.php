<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Material;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductionController extends Controller implements HasMiddleware
{
    protected $materials, $company;
    public function __construct(Request $request)
    {
        $this->materials = Material::where('type', 'material')->get();
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
    public function index()
    {
        $productions = Production::withTrashed()->where('branch_id', Session::get('branch'))->latest()->get();
        return view('production.index', compact('productions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materials = $this->materials;
        $companies = $this->company;
        return view('production.create', compact('materials', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
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
