@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Update Production ({{ ucfirst($type) }})</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            {{ html()->form('POST', route('production.update', ['type' => $type, 'id' => $production->id]))->attribute('id', 'frmProduction')->open() }}
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Production Date</label>
                                    {{ html()->date('date', $production->date->format('Y-m-d'))->class("form-control")->required() }}
                                    @error('date')
                                    <small class="text-danger">{{ $errors->first('date') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label req">Firm</label>
                                    {{ html()->select($name = 'from_company_id', $companies, $production->company_id)->class('form-control')->required() }}
                                    @error('from_company_id')
                                    <small class="text-danger">{{ $errors->first('from_company_id') }}</small>
                                    @enderror
                                </div>
                            </div>
                            @forelse($production->details->where('type', 'out') as $key => $item)
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Material / Product</label>
                                    {{ html()->select('items[]', $materials->where('id', $item->material_id)->pluck('name', 'id'), $item->material_id)->class('form-control') }}
                                    @error('items')
                                    <small class="text-danger">{{ $errors->first('items') }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label req">Qty</label>
                                    {{ html()->number('qty[]', $item->qty, '', '', 'any')->class("form-control")->placeholder("0.0")->required() }}
                                    @error('qty')
                                    <small class="text-danger">{{ $errors->first('qty') }}</small>
                                    @enderror
                                </div>
                            </div>
                            @empty
                            @endforelse
                            <div class="row">
                                <div class="col text-end">
                                    <a onClick="window.history.back()" class="btn btn-secondary">Cancel</a>
                                    {{ html()->submit("Update Production")->attribute('onClick', "return checkInventory('frmProduction', '$type')")->class("btn btn-submit btn-primary") }}
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