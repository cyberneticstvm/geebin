@extends("base")
@section("content")
<!-- Body: Body -->
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <div class="row clearfix row-deck">
                    <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6">
                        <div class="card mb-4 border-0 lift">
                            <div class="card-body">
                                <span class="text-uppercase">New Sessions</span>
                                <h4 class="mb-0 mt-2">22,500</h4>
                                <small class="text-muted">Analytics for last week</small>
                            </div>
                            <div id="apexspark1"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6">
                        <div class="card mb-4 border-0 lift">
                            <div class="card-body">
                                <span class="text-uppercase">TIME ON SITE</span>
                                <h4 class="mb-0 mt-2">1,070</h4>
                                <small class="text-muted">Analytics for last week</small>
                            </div>
                            <div id="apexspark2"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-4 col-sm-12">
                        <div class="card mb-4 border-0 lift">
                            <div class="card-body">
                                <span class="text-uppercase">BOUNCE RATE</span>
                                <h4 class="mb-0 mt-2">10K</h4>
                                <small class="text-muted">Analytics for last week</small>
                            </div>
                            <div id="apexspark3"></div>
                        </div>
                    </div>
                </div> <!-- .row end -->
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="row row-deck">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <div class="card mb-4 border-0 lift">
                            <div class="card-body">
                                <span class="text-uppercase">GOAL COMPLETIONS</span>
                                <h4 class="mb-0 mt-2">$1,22,500</h4>
                                <small class="text-muted">Analytics for last week</small>
                            </div>
                            <div id="apexspark4"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <div class="card mb-4 border-0 lift">
                            <div class="card-header py-3 bg-transparent border-0">
                                <h6 class="card-title mb-0">Active Users</h6>
                                <small class="text-muted">How do your users visited in the time.</small>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="p-2 flex-fill">
                                        <span class="text-muted">Daily (Avg)</span>
                                        <h5>1.08K</h5>
                                        <small class="text-success"><i class="fa fa-angle-up"></i>
                                            1.03%</small>
                                    </div>
                                    <div class="p-2 flex-fill">
                                        <span class="text-muted">Weekly</span>
                                        <h5>3.20K</h5>
                                        <small class="text-danger"><i class="fa fa-angle-down"></i>
                                            1.63%</small>
                                    </div>
                                    <div class="p-2 flex-fill">
                                        <span class="text-muted">Monthly</span>
                                        <h5>8.18K</h5>
                                        <small class="text-success"><i class="fa fa-angle-up"></i>
                                            4.33%</small>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- .card end -->
                    </div>
                </div> <!-- .row end -->
            </div>
        </div> <!-- .row end -->

    </div>
</div>
@endsection