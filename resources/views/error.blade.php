@extends("base")
@section("content")
<div class="body px-xl-4 px-md-2">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ asset('/assets/images/sad-face.svg') }}" width="10%" />
                        <p class="text-danger text-center">{{ $exception->getMessage() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection