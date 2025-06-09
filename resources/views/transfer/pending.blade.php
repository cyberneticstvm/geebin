@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Pending Transfer Register</h5>
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
                                    <th>Status</th>
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
                                    <td>{{ ucfirst($transfer->item) }}</td>
                                    <td>{{ ucfirst($transfer->approved_status) }}</td>
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