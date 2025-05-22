<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Extra;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CompanyController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('company-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('company-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('company-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('company-delete'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('company-restore'), only: ['restore']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::withTrashed()->orderBy('name')->get();
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Extra::where('key', 'ctype')->pluck('value', 'id');
        $branches = Branch::pluck('name', 'id');
        return view('company.create', compact('types', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type_id' => 'required',
            'branch_id' => 'required',
            'mobile' => 'nullable|numeric|digits:10'
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        Company::create($input);
        return redirect()->route('company.register')->with("success", "Firm created successfully");
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
        $company = Company::findOrFail(decrypt($id));
        $types = Extra::where('key', 'ctype')->pluck('value', 'id');
        $branches = Branch::pluck('name', 'id');
        return view('company.edit', compact('types', 'company', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'type_id' => 'required',
            'branch_id' => 'required',
            'mobile' => 'nullable|numeric|digits:10'
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        Company::findOrFail($id)->update($input);
        return redirect()->route('company.register')->with("success", "Firm updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Company::findOrFail(decrypt($id))->delete();
        return redirect()->route('company.register')->with("success", "Firm deleted successfully");
    }

    public function restore(string $id)
    {
        Company::withTrashed()->where('id', decrypt($id))->restore();
        return redirect()->route('company.register')->with("success", "Firm restored successfully");
    }
}
