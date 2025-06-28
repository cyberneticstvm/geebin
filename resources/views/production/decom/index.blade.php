<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Production ({{ $type->value }}) - <div class="btn-group mb-1">
                    <button type="button" class="btn ">Create</button>
                    <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('production.create', ['type' => encrypt($type->id), 'stype' => 1]) }}">Powder</a>
                        <a class="dropdown-item" href="{{ route('production.create', ['type' => encrypt($type->id), 'stype' => 2]) }}">Liquid & Powder</a>
                    </div>
                </div>
            </h5>

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
                                        <th>From Facility</th>
                                        <th>To Facility</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productions as $key => $prod)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $prod->fromEntity->name }}</td>
                                        <td>{{ $prod->toEntity->name }}</td>
                                        <td>{{ $prod->sub_type }}</td>
                                        <td>{!! $prod->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('production.edit', ['type' => encrypt(20), 'id' => encrypt($prod->id), 'stype' => $prod->sub_type]) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('production.delete', ['id' => encrypt($prod->id), 'type' => encrypt(20), 'stype' => $prod->sub_type]) }}" class="text-danger dlt">Delete</a></span></td>
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