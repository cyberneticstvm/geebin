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
                                        <th>From</th>
                                        <th>Production Unit</th>
                                        <th>Batch Number</th>
                                        <th>Material</th>
                                        <th>Consumed</th>
                                        <th>Output</th>
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
                                        <td><a href="javascript:void(0)" class="viewMaterialBox text-info" data-pid="{{ encrypt($prod->id) }}" data-bno="{{ $prod->batchNumber() }}">{{ $prod->batchNumber() }}</a></td>
                                        <td><a href="javascript:void(0)" class="viewMaterialDetailsBox text-info" data-pid="{{ encrypt($prod->id) }}" data-bno="{{ $prod->batchNumber() }}">View</a></td>
                                        <td></td>
                                        <td><a href="javascript:void(0)" class="viewProductionDetailsBox text-info" data-pid="{{ encrypt($prod->id) }}" data-bno="{{ $prod->batchNumber() }}">View</a></td>
                                        <td>{!! $prod->status() !!}</td>
                                        <td><span class="badge badge-lg light badge-warning"><a href="{{ route('production.edit', ['type' => encrypt(14), 'id' => encrypt($prod->id), 'stype' => $prod->sub_type]) }}" class="text-warning">Edit</a></span></td>
                                        <td><span class="badge badge-lg light badge-danger"><a href="{{ route('production.delete', ['id' => encrypt($prod->id), 'type' => encrypt(14), 'stype' => 0]) }}" class="text-danger dlt">Delete</a></span></td>
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
<!--**********************************
            Chat box start
        ***********************************-->
<div class="chatbox" id="materialBox">
    <div class="chatbox-close"></div>
    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
        <div class="card-header chat-list-header text-center">
            <h5><span class="bNumber"></span></h5>
        </div>
        <div class="card-body contacts_body p-0 dz-scroll materialBox" id="DZ_W_Contacts_Body">
            <div class="basic-form">
                <h5 class="ms-3 mt-3">Add Material to Batch</h5>
                {{ html()->form('POST', route('production.material.save'))->open() }}
                <input type="hidden" name="pid" class="pid" value="" />
                <div class="row ms-1 mt-3">
                    <div class="col-md-12">
                        <label class="form-label req">Item</label>
                        {{ html()->select($name = 'item_id', $items->where('type', 13)->pluck('name', 'id'), old('item_id'))->class('form-control single-select')->placeholder('Select')->required() }}
                        @error('item_id')
                        <small class="text-danger">{{ $errors->first('item_id') }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row ms-1 mt-1">
                    <div class="col-md-6">
                        <label class="form-label req">Qty</label>
                        {{ html()->text('qty', old('qty'))->class("form-control")->placeholder("0")->required() }}
                        @error('qty')
                        <small class="text-danger">{{ $errors->first('qty') }}</small>
                        @enderror
                    </div>
                    <div class="col-md-12 text-end">
                        {{ html()->submit("Add")->class("btn btn-submit btn-outline-primary") }}
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
            <div class="basic-form">
                <h5 class="ms-3 mt-3">Update Production (Parts)</h5>
                {{ html()->form('POST', route('production.parts.save'))->open() }}
                <input type="hidden" name="pid" class="pid" value="" />
                <div class="row ms-1 mt-3">
                    @forelse($items->where('type', 14) as $key => $part)
                    <div class="col-md-4">
                        <label class="form-label">{{ $part->name }}</label>
                        {{ html()->number(str_replace(' ', '_', $part->name), 0, 0, '', 1)->class('form-control'); }}
                        @error($part->name)
                        <small class="text-danger">{{ $errors->first($part->name) }}</small>
                        @enderror
                    </div>
                    @empty
                    @endforelse
                </div>
                <div class="row ms-1 mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Scrap</label>
                        {{ html()->number($items->where('type', 25)->first()->name, 0, 0, '', 'any')->class('form-control'); }}
                        @error($items->where('type', 25)->first()->name)
                        <small class="text-danger">{{ $errors->first($items->where('type', 25)->first()->name) }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row ms-1 mt-1">
                    <div class="col-md-12 text-end">
                        {{ html()->submit("Update")->class("btn btn-submit btn-outline-primary") }}
                    </div>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
        <div class="card-footer">
            <h5><span class="bNumber"></span></h5>
        </div>
    </div>
</div>
<!--**********************************
            Chat box End
        ***********************************-->

<!--**********************************
            Chat box start
        ***********************************-->
<div class="chatbox" id="materialDetailsBox">
    <div class="chatbox-close"></div>
    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
        <div class="card-header chat-list-header text-center">
            <h5>Material Details - <span class="bNumber"></span></h5>
        </div>
        <div class="card-body contacts_body p-0 dz-scroll mt-3 ms-3" id="DZ_W_Contacts_Body">
            <div class="table-responsive">
                <table class="display table">
                    <thead>
                        <tr>
                            <td class="fw-bold">SL No</td>
                            <td class="fw-bold">Item</td>
                            <td class="fw-bold">Qty</td>
                        </tr>
                    </thead>
                    <tbody class="materialDetails">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <h5>Material Details - <span class="bNumber"></span></h5>
        </div>
    </div>
</div>
<!--**********************************
            Chat box End
        ***********************************-->
<!--**********************************
            Chat box start
        ***********************************-->
<div class="chatbox" id="productionDetailsBox">
    <div class="chatbox-close"></div>
    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
        <div class="card-header chat-list-header text-center">
            <h5>Production Details - <span class="bNumber"></span></h5>
        </div>
        <div class="card-body contacts_body p-0 dz-scroll mt-3 ms-3" id="DZ_W_Contacts_Body">
            <div class="table-responsive">
                <table class="display table">
                    <thead>
                        <tr>
                            <td class="fw-bold">SL No</td>
                            <td class="fw-bold">Item</td>
                            <td class="fw-bold">Qty</td>
                        </tr>
                    </thead>
                    <tbody class="productionDetails">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <h5>Production Details - <span class="bNumber"></span></h5>
        </div>
    </div>
</div>
<!--**********************************
            Chat box End
        ***********************************-->