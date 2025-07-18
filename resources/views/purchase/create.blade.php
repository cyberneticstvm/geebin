@extends("base")
@section("content")
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h5 class="dashboard_bar">Purchase</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">
                        Home </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('purchase.register') }}">Purchase</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
            </ul>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card dz-card">
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('purchase.save'))->attribute('id', 'frmPurchase')->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Purchase Date</label>
                                    {{ html()->date('purchase_date', old('purchase_date') ?? date('Y-m-d'))->class("form-control") }}
                                    @error('purchase_date')
                                    <small class="text-danger">{{ $errors->first('purchase_date') }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label req">Entity</label>
                                    {{ html()->select($name = 'entity_id', $value = $entities, old('entity_id') ?? 1)->class('form-control single-select')->placeholder('Select') }}
                                    @error('entity_id')
                                    <small class="text-danger">{{ $errors->first('entity_id') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Purchase Note</label>
                                    {{ html()->text('purchase_note', old('purchase_note'))->class("form-control")->placeholder("Purchase Note") }}
                                    @error('purchase_note')
                                    <small class="text-danger">{{ $errors->first('purchase_note') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label req">Item</label>
                                    {{ html()->select($name = 'item_ids[]', $value = $items, old('item_ids'))->class('form-control single-select')->placeholder('Select') }}
                                    @error('item_ids')
                                    <small class="text-danger">{{ $errors->first('item_ids') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Qty</label>
                                    {{ html()->text('qty[]', old('qty'))->class("form-control")->placeholder("0") }}
                                    @error('qty')
                                    <small class="text-danger">{{ $errors->first('qty') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-light btn-warning btn-link">Cancel</a>
                                    {{ html()->submit("Save Purchase")->attribute('onClick', "return validateForm('frmPurchase')")->class("btn btn-submit btn-outline-primary") }}
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