@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Production ({{ $type->value }})</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('production.register', ['type' => encrypt($type->id), 'stype' => 0]) }}">Production</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('production.save', ['type' => encrypt($type->id), 'stype' => 0]))->attribute('id', 'frmProduction')->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Production Date</label>
                                    {{ html()->date('production_date', old('production_date') ?? date('Y-m-d'))->class("form-control")->required() }}
                                    @error('production_date')
                                    <small class="text-danger">{{ $errors->first('production_date') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label req">Facility</label>
                                    {{ html()->select($name = 'to_entity', $value = $entities->where('type_id', 4)->pluck('name', 'id'), old('to_entity') ?? 1)->class('form-control single-select')->placeholder('Select')->required() }}
                                    @error('to_entity')
                                    <small class="text-danger">{{ $errors->first('to_entity') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Production Note</label>
                                    {{ html()->text('production_note', old('production_note'))->class("form-control")->placeholder("Purchase Note") }}
                                    @error('production_note')
                                    <small class="text-danger">{{ $errors->first('production_note') }}</small>
                                    @enderror
                                </div>
                            </div>
                            @forelse($items as $key => $item)
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label req">Item</label>
                                    {{ html()->select($name = 'item_ids[]', $items->where('id', $item->id)->pluck('name', 'id'), old('item_ids'))->class('form-control single-select')->attribute('id', $item->name)->placeholder('Select')->required() }}
                                    @error('item_ids')
                                    <small class="text-danger">{{ $errors->first('item_ids') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Qty</label>
                                    {{ html()->text('qty[]', 0)->class("form-control")->placeholder("0")->required() }}
                                    @error('qty')
                                    <small class="text-danger">{{ $errors->first('qty') }}</small>
                                    @enderror
                                </div>
                            </div>
                            @empty
                            @endforelse
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Save Production")->attribute('onClick', "return validateForm('frmProduction')")->class("btn btn-submit btn-outline-primary") }}
                                </div>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection