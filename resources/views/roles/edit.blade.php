@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Update User Role</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('role.update', $role->id))->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label req">Role Name</label>
                                    {{ html()->text('name', $role->name)->class("form-control")->placeholder("Role Name") }}
                                    @error('name')
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-lg-12 col-md-6"><label class="form-label req">Permissions</label></div>
                                @foreach($permissions as $permission)
                                <div class="col-lg-2 col-4">
                                    <label class="form-check-label" for="">{{ $permission->name }}</label><br />
                                    {{ html()->checkbox($name = 'permission[]', in_array($permission->id, $rolePermissions) ? true : false, $value = $permission->id)->class('form-check-input') }}
                                </div>
                                @endforeach
                                @error('permission')
                                <small class="text-danger">{{ $errors->first('permission') }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-secondary">Cancel</a>
                                    {{ html()->submit("Update Role")->class("btn btn-submit btn-primary") }}
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