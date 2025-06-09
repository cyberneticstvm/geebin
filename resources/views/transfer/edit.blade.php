@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Update {{ ucfirst($transfer->item) }} Transfer</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('transfer.update', [$transfer->item, $transfer->id]))->attribute('id', 'frmTransfer')->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Transfer Date</label>
                                    {{ html()->date('date', $transfer->date->format('Y-m-d'))->class("form-control") }}
                                    @error('date')
                                    <small class="text-danger">{{ $errors->first('date') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">From</label>
                                    {{ html()->select($name = 'from_company_id', $fromCompany, $transfer->from_company_id)->class('form-control')->placeholder('Select') }}
                                    @error('from_company_id')
                                    <small class="text-danger">{{ $errors->first('from_company_id') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">To</label>
                                    {{ html()->select($name = 'to_company_id', $toCompany, $transfer->to_company_id)->class('form-control')->placeholder('Select') }}
                                    @error('to_company_id')
                                    <small class="text-danger">{{ $errors->first('to_company_id') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Transfer Note</label>
                                    {{ html()->text('notes', $transfer->notes)->class("form-control")->placeholder("Transfer Note") }}
                                    @error('notes')
                                    <small class="text-danger">{{ $errors->first('notes') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Item</label>
                                    {{ html()->select('items[]', $products, $transfer->details?->first()?->item)->class('form-control')->placeholder('Select') }}
                                    @error('items')
                                    <small class="text-danger">{{ $errors->first('items') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Qty</label>
                                    {{ html()->number('qty[]', $transfer->details?->first()?->qty, '', '', 'any')->class("form-control")->placeholder("0.0") }}
                                    @error('qty')
                                    <small class="text-danger">{{ $errors->first('qty') }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-secondary">Cancel</a>
                                    {{ html()->submit("Update Transfer")->attribute('onClick', "return checkInventory('frmTransfer', '$item')")->class("btn btn-submit btn-primary") }}
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