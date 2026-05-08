@extends('layouts.master')

@section('title', isset($header) ? $header : 'Retail Pro')

@section('content')
    @isset($header)
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $header }}</h4>
            </div>
        </div>
    </div>
    @endisset

    {{ $slot ?? '' }}
@endsection