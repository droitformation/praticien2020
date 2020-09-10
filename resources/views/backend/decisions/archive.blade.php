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

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ url('backend/decision/search') }}" method="POST">@csrf
                        <div class="input-group mb-0">
                            <input type="text" class="form-control" name="numero" placeholder="Recherche par référence">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="supprimer" id="button-addon2">OK</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @if(!$decisions->isEmpty())
        @foreach($decisions as $year => $dates)
            @include('backend.decisions.partials.year',['dates' => $dates, 'year' => $year])
        @endforeach
    @endif

</div>

@stop
