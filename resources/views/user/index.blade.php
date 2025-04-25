@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">User Register</h5>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="m-0"><a href="{{ route('user.create') }}" class="text-success">Create New User</a></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-start">{{ $user->roles()->pluck('name')->implode(', ') }}</td>
                                    <td class="text-start">{!! $user->status() !!}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-link dropdown-toggle after-none" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></button>
                                            <ul class="dropdown-menu border-0 shadow p-3">
                                                <li><a class="dropdown-item py-2 rounded" href="{{ route('user.edit', encrypt($user->id)) }}">Edit <i class="ps-3 fa fa-pencil text-warning"></i></a></li>
                                                @if($user->deleted_at)
                                                <li><a class="dropdown-item py-2 rounded proceed" href="{{ route('user.restore', encrypt($user->id)) }}">Restore <i class="ps-3 fa fa-recycle text-success"></i></a></li>
                                                @else
                                                <li><a class="dropdown-item py-2 rounded dlt" href="{{ route('user.delete', encrypt($user->id)) }}">Delete <i class="ps-3 fa fa-trash text-danger"></i></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
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