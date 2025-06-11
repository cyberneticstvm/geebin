@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Production Register ({{ ucfirst($type) }})</h5>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="m-0"><a href="{{ route('production.create', $type) }}" class="text-success">Create New Production</a></h5>
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
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Product</th>
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
                                    <td>
                                        {{ $materials->whereIn('id', $pro->details->pluck('material_id'))->pluck('name')->implode(' | ') }}<br />
                                        {{ $pro->details->pluck('qty')->implode(' | ') }}
                                    </td>
                                    <td>{{ ucfirst($pro->type) }}</td>
                                    <td class="text-start">{!! $pro->status() !!}</td>
                                    @if($pro->type == 'parts')
                                    <td><a href="#" data-bs-toggle="modal" data-bs-target="#partsModal" data-modal="partsModal" data-pid="{{ $pro->id }}" data-type="{{ $pro->type }}" class="myModal">Update</a></td>
                                    @else
                                    <td><a href="#" data-bs-toggle="modal" data-bs-target="#mixingModal" data-modal="mixingModal" data-pid="{{ $pro->id }}" data-type="{{ $pro->type }}" class="myModal">Update</a></td>
                                    @endif
                                    <td class="text-center"><a href="{{ route('production.edit', ['type' => $pro->type, 'id' => encrypt($pro->id)]) }}"><i class="fa fa-pencil text-warning"></i></a></td>
                                    @if($pro->deleted_at)
                                    <td class="text-center"><a href="{{ route('production.restore', ['type' => $pro->type, 'id' => encrypt($pro->id)]) }}" class="proceed"><i class="fa fa-recycle text-success"></i></a></td>
                                    @else
                                    <td class="text-center"><a href="{{ route('production.delete', ['type' => $pro->type, 'id' => encrypt($pro->id)]) }}" class="dlt"><i class="fa fa-trash text-danger"></i></a></td>
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
<div class="modal fade" id="partsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-vertical modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Production Output Update (Parts) - <span class="productionId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom_scroll">
                <div class="basic-form">
                    {{ html()->form('POST', route('production.output.update'))->open() }}
                    <input type="hidden" name="productionId" id="productionId" value="" />
                    <input type="hidden" name="type" value="parts" />
                    <div class="row">
                        <div class="col text-end">
                            {{ html()->submit("Update")->class("btn btn-submit btn-primary") }}
                        </div>
                    </div>
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mixingModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-vertical modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Production Output Update (Mixing) - <span class="productionId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom_scroll">
                <div class="basic-form">
                    {{ html()->form('POST', route('production.output.update'))->open() }}
                    <input type="hidden" name="productionId" id="productionId" value="" />
                    <input type="hidden" name="type" value="mixing" />
                    <div class="row">
                        <div class="col text-end">
                            {{ html()->submit("Update")->class("btn btn-submit btn-primary") }}
                        </div>
                    </div>
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection