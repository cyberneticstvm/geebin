@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Create Material</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('material.save'))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label req">Material Name</label>
                                    {{ html()->text('name', old('name'))->class("form-control")->placeholder("Material Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Type</label>
                                    {{ html()->select($name = 'type', materialTypes(), old('type'))->class('form-control')->placeholder('Select') }}
                                    @error('type')
                                    <small class="text-danger">{{ $errors->first('type') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Unit</label>
                                    {{ html()->select($name = 'unit', $value = array('Kilo' => 'Kilo', 'Number' => 'Number', 'Litre' => 'Litre'), old('unit'))->class('form-control')->placeholder('Select') }}
                                    @error('unit')
                                    <small class="text-danger">{{ $errors->first('unit') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Cost per Unit</label>
                                    {{ html()->number('cost_per_unit', old('cost_per_unit'))->class("form-control")->placeholder("0.0") }}
                                    @error('cost_per_unit')
                                    <small class="text-danger">{{ $errors->first('cost_per_unit') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-secondary">Cancel</a>
                                    {{ html()->submit("Save Material")->class("btn btn-submit btn-primary") }}
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