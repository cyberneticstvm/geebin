@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Create User</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('user.save'))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-5">
                                    <label class="form-label req">Full Name</label>
                                    {{ html()->text('name', old('name'))->class("form-control")->placeholder("Full Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Email</label>
                                    {{ html()->email('email', old('email'))->class("form-control")->placeholder("Email") }}
                                    @error('email')
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Password</label>
                                    {{ html()->password('password', '')->class("form-control")->placeholder("******") }}
                                    @error('password')
                                    <small class="text-danger">{{ $errors->first('password') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label req">Role</label>
                                    {{ html()->select($name = 'roles', $value = $roles, old('roles'))->class('form-control')->placeholder('Select') }}
                                    @error('roles')
                                    <small class="text-danger">{{ $errors->first('roles') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label req">Branch</label>
                                    {{ html()->select($name = 'branches[]', $value = $branches, old('branches'))->class('form-control select2')->multiple() }}
                                    @error('branches')
                                    <small class="text-danger">{{ $errors->first('branches') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-secondary">Cancel</a>
                                    {{ html()->submit("Save User")->class("btn btn-submit btn-primary") }}
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