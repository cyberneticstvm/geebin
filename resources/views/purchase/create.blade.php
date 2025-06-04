@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Create Purchase</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('purchase.save'))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Purchase Date</label>
                                    {{ html()->date('date', old('date') ?? date('Y-m-d'))->class("form-control") }}
                                    @error('date')
                                    <small class="text-danger">{{ $errors->first('date') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Supplier</label>
                                    {{ html()->select($name = 'supplier_id', $companies->where('type_id', 4)->pluck('name', 'id'), old('supplier_id'))->class('form-control')->placeholder('Select') }}
                                    @error('supplier_id')
                                    <small class="text-danger">{{ $errors->first('supplier_id') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Firm / Company</label>
                                    {{ html()->select($name = 'company_id', $companies->where('type_id', 5)->pluck('name', 'id'), old('company_id'))->class('form-control')->placeholder('Select') }}
                                    @error('company_id')
                                    <small class="text-danger">{{ $errors->first('company_id') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Purchase Note</label>
                                    {{ html()->text('notes', old('notes'))->class("form-control")->placeholder("Purchase Note") }}
                                    @error('notes')
                                    <small class="text-danger">{{ $errors->first('notes') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Material</label>
                                    {{ html()->select('material_ids[]', $materials->pluck('name', 'id'), old('material_ids')[0] ?? '')->class('form-control')->placeholder('Select') }}
                                    @error('material_ids')
                                    <small class="text-danger">{{ $errors->first('material_ids') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Qty</label>
                                    {{ html()->number('qty[]', old('qty')[0] ?? '', '', '', 'any')->class("form-control")->placeholder("0.0") }}
                                    @error('qty')
                                    <small class="text-danger">{{ $errors->first('qty') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-secondary">Cancel</a>
                                    {{ html()->submit("Save Purchase")->class("btn btn-submit btn-primary") }}
                                </div>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection