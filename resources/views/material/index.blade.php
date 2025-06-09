@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Raw Material Register</h5>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="m-0"><a href="{{ route('material.create') }}" class="text-success">Create New Material</a></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Material Name</th>
                                    <th>Material Type</th>
                                    <th>Unit</th>
                                    <th>Cost per Unit</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete / Restore</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materials as $key => $material)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $material->name }}</td>
                                    <td>{{ ucfirst($material->type) }}</td>
                                    <td>{{ $material->unit }}</td>
                                    <td>{{ $material->cost_per_unit }}</td>
                                    <td class="text-start">{!! $material->status() !!}</td>
                                    <td class="text-center"><a href="{{ route('material.edit', encrypt($material->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                    @if($material->deleted_at)
                                    <td class="text-center"><a href="{{ route('material.restore', encrypt($material->id)) }}" class="proceed"><i class="fa fa-recycle text-success"></i></a></td>
                                    @else
                                    <td class="text-center"><a href="{{ route('material.delete', encrypt($material->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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