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
                                        <th>Batch Number</th>
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
                                        <td><a href="javascript:void(0)" class="viewDecomBox text-info" data-pid="{{ encrypt($prod->id) }}" data-bno="{{ $prod->batchNumber() }}">{{ $prod->batchNumber() }}</a></td>
                                        <td>{{ $prod->fromEntity->name }}</td>
                                        <td>{{ $prod->toEntity->name }}</td>
                                        <td>{{ ($prod->sub_type == 1) ? 'Powder' : 'Liquid' }}</td>
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
<!--**********************************
            Chat box start
        ***********************************-->
<div class="chatbox" id="decomBox">
    <div class="chatbox-close"></div>
    <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
        <div class="card-header chat-list-header text-center">
            <h5><span class="bNumber"></span></h5>
        </div>
        <div class="card-body contacts_body p-0 dz-scroll decomBox" id="DZ_W_Contacts_Body">
            <div class="basic-form">
                <h5 class="ms-3 mt-3">Update Production (Decom)</h5>
                {{ html()->form('POST', route('production.decom.save'))->open() }}
                <input type="hidden" name="pid" class="pid" value="" />
                <div class="row ms-1 mt-3">
                    @forelse($items as $key => $part)
                    <div class="col-md-6">
                        <label class="form-label">{{ $part->name }}</label>
                        {{ html()->number(str_replace(' ', '_', $part->name), 0, 0, '', 1)->class('form-control')->required() }}
                        @error($part->name)
                        <small class="text-danger">{{ $errors->first($part->name) }}</small>
                        @enderror
                    </div>
                    @empty
                    @endforelse
                </div>
                <div class="row ms-1 mt-3">
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