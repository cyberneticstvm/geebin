@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Create Firm</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('branch.update', $branch->id))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Branch Name</label>
                                    {{ html()->text('name', $branch->name)->class("form-control")->placeholder("Branch Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Branch Code</label>
                                    {{ html()->text('code', $branch->code)->class("form-control")->maxlength(10)->placeholder("Branch Code") }}
                                    @error('code')
                                    <small class="text-danger">{{ $errors->first('code') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Mobile</label>
                                    {{ html()->text('mobile', $branch->mobile)->class("form-control")->maxlength(10)->placeholder("Mobile") }}
                                    @error('mobile')
                                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Email</label>
                                    {{ html()->email('email', $branch->email)->class("form-control")->placeholder("Email") }}
                                    @error('email')
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label req">Address</label>
                                    {{ html()->text('address', $branch->address)->class("form-control")->placeholder("Address") }}
                                    @error('address')
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-secondary">Cancel</a>
                                    {{ html()->submit("Upadte Branch")->class("btn btn-submit btn-primary") }}
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