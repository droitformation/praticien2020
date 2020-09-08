@extends('layouts.app')
@section('content')

<div class="container-fluid">

    <div class="row page-title">
        <div class="col-md-12">
            <h3 class="mb-0 mt-0"><a href="{{ secure_url('backend/arret') }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp; Retour</a></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-8">

           @if($alert)
                <div class="card">
                    <div class="card-body">
                       {!! $alert !!}
                    </div>
                </div>
           @endif

            <div class="card">
                <div class="card-body">

                    @foreach($users as $user)

                        <div class="card position-relative mb-0 border-bottom">
                            <div class="row no-gutters">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <div class="d-flex flex-row justify-content-between">
                                            <div class="media-body">
                                                <h5 class="mt-1 mb-0">{{ $user->email }} &nbsp;<span class="badge badge-success badge-pill font-size-12">{{ $user->cadence }}</span></h5>
                                                <p>Actif | <span class="text-info">{{ isset($user->active_until) ? $user->active_until->format('Y-m-d') : '' }}</span></p>
                                            </div>
                                            @if(!$user->abonnements->isEmpty())
                                                <div class="card-text text-center">
                                                    <div class="col">
                                                        <button class="btn btn-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#collapse_{{ $user->id }}" aria-expanded="false" aria-controls="collapse:{{ $user->id }}">Abonnements</button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        @if(!$user->abonnements->isEmpty())
                                            <div class="collapse" id="collapse_{{ $user->id }}">
                                                <div class="d-flex flex-row justify-content-between flex-wrap" >
                                                    @foreach($user->abonnements as $abo)
                                                        <div class="card card-categorie border">
                                                            <div class="card-body">
                                                                <p class="m-0"><strong>Catégorie:</strong> <span class="{{ $abo['published'] ? 'text-info' : '' }}">{{ $abo['title'] }}</span></p>
                                                                {!! !$abo['keywords']->flatten()->isEmpty() ? '<p class="m-0 font-italic">'.$abo['keywords']->flatten()->implode(', ').'</p>' : '' !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
        </div>
        <div class="col-4">

            <div class="card">
                <div class="card-body">

                    <h3>Tester abo et date</h3>
                    <form action="{{ url('backend/abos') }}" method="POST" class="mb-2">{!! csrf_field() !!}
                        <div class="form-group">
                            @if(!$users->isEmpty())
                                <select class="custom-select" name="user_id">
                                    @foreach($users as $user)
                                        <option {{ $user_id == $user->id ? 'selected' : '' }} value="{{ $user->id }}">
                                            {{ $user->name }} - {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control datepicker" name="date" placeholder="date">
                        </div>
                        <div class="form-group">
                            <select name="cadence" class="form-control">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-sm" type="submit">Tester</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@stop
