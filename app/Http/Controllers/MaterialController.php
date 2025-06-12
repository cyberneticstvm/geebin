<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MaterialController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('material-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('material-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('material-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('material-delete'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('material-restore'), only: ['restore']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::withTrashed()->orderBy('name')->get();
        return view('material.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('material.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:materials,name',
            'unit' => 'required',
            'type' => 'required',
            'cost_per_unit' => 'required',
        ]);
        $input = $request->all();
        $input['name'] = str_replace(' ', '-', $request->name);
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        Material::create($input);
        return redirect()->route('material.register')->with("success", "Material created successfully");
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
        $material = Material::findOrFail(decrypt($id));
        return view('material.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:materials,name,' . $id,
            'unit' => 'required',
            'type' => 'required',
            'cost_per_unit' => 'required',
        ]);
        $input = $request->all();
        $input['name'] = str_replace(' ', '-', $request->name);
        $input['updated_by'] = $request->user()->id;
        Material::findOrFail($id)->update($input);
        return redirect()->route('material.register')->with("success", "Material updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Material::findOrFail(decrypt($id))->delete();
        return redirect()->route('material.register')->with("success", "Material deleted successfully");
    }

    public function restore(string $id)
    {
        Material::withTrashed()->where('id', decrypt($id))->restore();
        return redirect()->route('material.register')->with("success", "Material restored successfully");
    }
}
