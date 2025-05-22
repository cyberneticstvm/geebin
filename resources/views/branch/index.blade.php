@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Branch Register</h5>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="m-0"><a href="{{ route('branch.create') }}" class="text-success">Create Branch</a></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Branch Name</th>
                                    <th>Branch Code</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete / Restore</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($branches as $key => $branch)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $branch->name }}</td>
                                    <td>{{ $branch->code }}</td>
                                    <td>{{ $branch->mobile }}</td>
                                    <td>{{ $branch->email }}</td>
                                    <td>{{ $branch->address }}</td>
                                    <td class="text-start">{!! $branch->status() !!}</td>
                                    <td class="text-center"><a href="{{ route('branch.edit', encrypt($branch->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                    @if($branch->deleted_at)
                                    <td class="text-center"><a href="{{ route('branch.restore', encrypt($branch->id)) }}" class="proceed"><i class="fa fa-recycle text-success"></i></a></td>
                                    @else
                                    <td class="text-center"><a href="{{ route('branch.delete', encrypt($branch->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
                                    @endif
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