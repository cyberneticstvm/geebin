@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">{{ ucfirst($item) }} Transfer Register</h5>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="m-0"><a href="{{ route('transfer.create', $item) }}" class="text-success">Create New Transfer</a></h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Transfer Id</th>
                                    <th>Date</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Item</th>
                                    <th>T. Status</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete / Restore</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transfers as $key => $transfer)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $transfer->id }}</td>
                                    <td>{{ $transfer->date->format('d.M.Y') }}</td>
                                    <td>{{ $transfer->fromCompany?->name }}</td>
                                    <td>{{ $transfer->toCompany?->name }}</td>
                                    <td>{{ ucfirst($item) }}</td>
                                    <td>{{ ucfirst($transfer->approved_status) }}</td>
                                    <td class="text-start">{!! $transfer->status() !!}</td>
                                    <td class="text-center"><a href="{{ route('transfer.edit', ['item' => $transfer->item, 'id' => encrypt($transfer->id)]) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                    @if($transfer->deleted_at)
                                    <td class="text-center"><a href="{{ route('transfer.restore', ['item' => $transfer->item, 'id' => encrypt($transfer->id)]) }}" class="proceed"><i class="fa fa-recycle text-success"></i></a></td>
                                    @else
                                    <td class="text-center"><a href="{{ route('transfer.delete', ['item' => $transfer->item, 'id' => encrypt($transfer->id)]) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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