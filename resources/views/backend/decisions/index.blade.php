@extends('layouts.app')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row page-title">
            <div class="col-md-12">
                <h3 class="mb-1 mt-0">Arrêts du TF</h3>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mt-0">Manquantes</h3>
                        @if(!$liste->isEmpty())
                            @foreach($liste as $date)
                                <div class="row">
                                    <div class="col-sm"><p class="mb-2">{{ $date }}</p></div>
                                    <form action="{{ url('backend/date/update') }}" method="POST" class="col-sm text-right">{!! csrf_field() !!}
                                        <input name="date" value="{{ $date }}" type="hidden">
                                        <button class="btn btn-primary btn-sm">Insérer</button>
                                    </form>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mt-0">Existante</h3>
                        @if(!$exist->isEmpty())
                            @foreach($exist as $date => $count)
                                <div class="row">
                                    <div class="col-sm"><p class="mb-2"><span class="badge badge-primary">{{ $count }}</span></p></div>
                                    <div class="col-sm"><p class="mb-2">{{ $date }}</p></div>
                                    <form action="{{ url('backend/date/delete') }}" method="POST" class="col-sm text-right">{!! csrf_field() !!}
                                        <input name="date" value="{{ $date }}" type="hidden">
                                        <button class="btn btn-danger btn-sm btn-cross">X</button>
                                    </form>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('backend/date/update') }}" method="POST">{!! csrf_field() !!}
                            <div class="form-group">
                                <h3>Insérer date</h3>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control datePicker" id="newdate" name="date" placeholder="">
                                    <div class="input-group-prepend">
                                        <button type="submit" class="btn btn-primary">Envoyer</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('backend/date/update') }}" method="POST">{!! csrf_field() !!}
                            <h3>Insérer période</h3>
                            <div class="form-group">
                                <input type="text" class="form-control datePicker" id="range1" name="range[0]" placeholder="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control datePicker" id="range2" name="range[1]" placeholder="">
                            </div>
                            <p class="text-right"><button type="submit" class="btn btn-primary">Envoyer</button></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(!$total->isEmpty())
            @foreach($total as $year => $dates)
                @include('backend.decisions.partials.year',['dates' => $dates, 'year' => $year])
            @endforeach
        @endif

    </div>
@stop
