@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Purchase Register</h5>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="m-0"><a href="{{ route('purchase.create') }}" class="text-success">Create New Purchase</a></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Purchase Id</th>
                                    <th>Date</th>
                                    <th>Supplier</th>
                                    <th>Firm</th>
                                    <th>Material</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete / Restore</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $key => $purchase)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $purchase->id }}</td>
                                    <td>{{ $purchase->date->format('d.M.Y') }}</td>
                                    <td>{{ $purchase->supplier?->name }}</td>
                                    <td>{{ $purchase->company?->name }}</td>
                                    <td>{{ $materials->whereIn('id', $purchase->details->pluck('material_id'))->pluck('name')->implode(', ') }}</td>
                                    <td class="text-start">{!! $purchase->status() !!}</td>
                                    <td class="text-center"><a href="{{ route('purchase.edit', encrypt($purchase->id)) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                    @if($purchase->deleted_at)
                                    <td class="text-center"><a href="{{ route('purchase.restore', encrypt($purchase->id)) }}" class="proceed"><i class="fa fa-recycle text-success"></i></a></td>
                                    @else
                                    <td class="text-center"><a href="{{ route('purchase.delete', encrypt($purchase->id)) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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