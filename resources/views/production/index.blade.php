@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Production Register</h5>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="m-0"><a href="{{ route('production.create') }}" class="text-success">Create New Production</a></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Production Id</th>
                                    <th>Date</th>
                                    <th>Firm</th>
                                    <th>Material</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete / Restore</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productions as $key => $pro)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $pro->id }}</td>
                                    <td>{{ $pro->date->format('d.M.Y') }}</td>
                                    <td>{{ $pro->company?->name }}</td>
                                    <td></td>
                                    <td class="text-start">{!! $pro->status() !!}</td>
                                    <td class="text-center"><a href="{{ route('production.edit', ['item' => $pro->item, 'id' => encrypt($pro->id)]) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                    @if($pro->deleted_at)
                                    <td class="text-center"><a href="{{ route('production.restore', ['item' => $pro->item, 'id' => encrypt($pro->id)]) }}" class="proceed"><i class="fa fa-recycle text-success"></i></a></td>
                                    @else
                                    <td class="text-center"><a href="{{ route('production.delete', ['item' => $pro->item, 'id' => encrypt($pro->id)]) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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