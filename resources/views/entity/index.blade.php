@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Entity - <a href="{{ route('entity.create') }}">Create New</a></h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Entity</a></li>
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
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Branch</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($entities as $key => $entity)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $entity->name }}</td>
                                        <td>{{ $entity->code }}</td>
                                        <td>{{ $entity->type->value }}</td>
                                        <td>{{ $entity->branch->name }}</td>
                                        <td>{{ $entity->contact_number }}</td>
                                        <td>{{ $entity->address }}</td>
                                        <td>{!! $entity->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('entity.edit', encrypt($entity->id)) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('entity.delete', encrypt($entity->id)) }}" class="text-danger dlt">Delete</a></span></td>
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