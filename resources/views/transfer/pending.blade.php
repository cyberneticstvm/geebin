@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 mt-3">
                        <div class="col-6">
                            <h5 class="m-0">Pending Transfer Register</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Transfer Id</th>
                                    <th>Date</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Item</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transfers as $key => $transfer)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $transfer->id }}</td>
                                    <td>{{ $transfer->date->format('d.M.Y') }}</td>
                                    <td>{{ $transfer->fromCompany?->name }}</td>
                                    <td>{{ $transfer->toCompany?->name }}</td>
                                    <td>{{ ucfirst($transfer->item) }}</td>
                                    <td><a href="#" data-bs-toggle="modal" data-bs-target="#transferStatusModal" data-modal="transferStatusModal" data-tid="{{ $transfer->id }}" class="myModal">{{ ucfirst($transfer->approved_status) }}</a></td>
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
<div class="modal fade" id="transferStatusModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-vertical modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transfer Status Update - <span class="transferId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom_scroll">
                <div class="basic-form">
                    {{ html()->form('POST', route('transfer.pending.status.update'))->open() }}
                    <input type="hidden" name="transferId" id="transferId" value="" />
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label class="form-label req">Status</label>
                            {{ html()->select($name = 'status', array('approved' => 'Approve', 'pending' => 'Pending', 'rejected' => 'Reject'), old('status'))->class('form-control')->placeholder('Select')->required() }}
                            @error('status')
                            <small class="text-danger">{{ $errors->first('status') }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Remarks</label>
                            {{ html()->textarea('remarks', old('remarks'))->rows('5')->class("form-control")->placeholder("Remarks")->required() }}
                            @error('remarks')
                            <small class="text-danger">{{ $errors->first('remarks') }}</small>
                            @enderror
                        </div>
                    </div>
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
    @endsection