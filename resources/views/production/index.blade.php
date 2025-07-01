@extends("base")
@section("content")
@if($type->id == 14)
@include("production.parts.index")
@endif
@if($type->id == 15)
@include("production.bin.index")
@endif
@if($type->id == 20)
@include("production.decom.index")
@endif
@endsection