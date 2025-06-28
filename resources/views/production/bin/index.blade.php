<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Production ({{ $type->value }}) - <a href="{{ route('production.create', ['type' => encrypt($type->id), 'stype' => 0]) }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Production</a></li>
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
                                        <th>Assembling Unit</th>
                                        <th>Date</th>
                                        <th>Production</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productions as $key => $prod)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $prod->toEntity->name }}</td>
                                        <td>{{ $prod->production_date->format('d.M.Y') }}</td>
                                        <td>2 Bin | 3 bin <br>{{ $prod->details->where('type', 'in')->pluck('qty')->implode(" | ") }}</td>
                                        <td>{!! $prod->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('production.edit', ['type' => encrypt(15), 'id' => encrypt($prod->id), 'stype' => $prod->sub_type]) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('production.delete', ['id' => encrypt($prod->id), 'type' => encrypt(15), 'stype' => 0]) }}" class="text-danger dlt">Delete</a></span></td>
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