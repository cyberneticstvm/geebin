@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Entity</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('entity.register') }}">Entity</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Update</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('entity.update', encrypt($entity->id)))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Entity Name</label>
                                    {{ html()->text('name', $entity->name)->class("form-control")->placeholder("Entity Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Enity Code</label>
                                    {{ html()->text('code', $entity->code)->class("form-control")->placeholder("Entity Code") }}
                                    @error('code')
                                    <small class="text-danger">{{ $errors->first('code') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label req">Entity Type</label>
                                    {{ html()->select($name = 'type_id', $value = $types, $entity->type_id)->class('form-control single-select')->placeholder('Select') }}
                                    @error('type_id')
                                    <small class="text-danger">{{ $errors->first('type_id') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label req">Branch</label>
                                    {{ html()->select($name = 'branch_id', $value = $branches, $entity->branch_id)->class('form-control single-select')->placeholder('Select') }}
                                    @error('branch_id')
                                    <small class="text-danger">{{ $errors->first('branch_id') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Contact Number</label>
                                    {{ html()->text('contact_number', $entity->contact_number)->class("form-control")->maxlength(10)->placeholder("Contact Number") }}
                                    @error('contact_number')
                                    <small class="text-danger">{{ $errors->first('contact_number') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Address</label>
                                    {{ html()->text('address', $entity->address)->class("form-control")->placeholder("Address") }}
                                    @error('address')
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Update Entity")->class("btn btn-submit btn-outline-primary") }}
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