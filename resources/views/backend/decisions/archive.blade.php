@extends('layouts.app')
@section('content')

<div class="container-fluid mt-4">
    <div class="row page-title">
        <div class="col-md-4">
            <h3 class="mb-1 mt-0">Archives</h3>
        </div>
        <div class="col-md-8 text-right">
            @foreach(range(2014,date('Y')) as $y)
                <a href="{{ secure_url('backend/archive/'.$y) }}" class="btn btn-sm btn-primary"><i class="fas fa-calendar"></i> &nbsp;{{ $y }}</a>
            @endforeach
        </div>
    </div>

    @if(!$decisions->isEmpty())
        @foreach($decisions as $year => $dates)
            @include('backend.decisions.partials.year',['dates' => $dates, 'year' => $year])
        @endforeach
    @endif

</div>

@stop
