@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Item Register</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Item</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Unit</th>
                                        <th>2Bin-Qty</th>
                                        <th>3Bin-Qty</th>
                                        <th>PPCP</th>
                                        <th>Color</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->itype->value }}</td>
                                        <td>{{ $item->iunit->value }}</td>
                                        <td>{{ $item->two_bin_parts_qty }}</td>
                                        <td>{{ $item->three_bin_parts_qty }}</td>
                                        <td>{{ $item->ppcp_qty_for_one }}</td>
                                        <td>{{ $item->color_qty_for_one }}</td>
                                        <td>{{ $item->total_qty_for_one }}</td>
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
</div>
@endsection