@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">User Roles</h5>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="m-0"><a href="{{ route('role.create') }}" class="text-success">Create New Role</a></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $key => $role)
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $role->name }}</td>
                                <td></td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle after-none" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                                        <ul class="dropdown-menu border-0 shadow p-3">
                                            <li><a class="dropdown-item py-2 rounded" href="{{ route('role.edit', encrypt($role->id)) }}">Edit <i class="ps-3 fa fa-pencil text-warning"></i></a></li>
                                        </ul>
                                    </div>
                                </td>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection