@extends('layouts.app')
@section('content')

<div class="container-fluid mt-4">
    <div class="row page-title">
        <div class="col-md-10">
            <h3 class="mb-1 mt-0">Utilisateurs</h3>
        </div>
        <div class="col-md-2 text-right">
            <a href="{{ secure_url('backend/user/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> &nbsp;Ajouter</a>
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

            <div id="user-list">

                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="search form-control" placeholder="recherche">
                </div>

                <div class="card">
                    <div class="card-body p-0 list">

                        @foreach($users as $user)

                            <div class="card position-relative mb-0 border-bottom">
                                <div class="row no-gutters">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="d-flex flex-row justify-content-between align-items-center">
                                                <div class="media-body">
                                                    <h5 class="name mb-2">{{ $user->name }} &nbsp;<span class="badge badge-success badge-pill font-size-12">{{ $user->cadence }}</span></h5>
                                                    <h5 class="mt-1 mb-2 email font-size-13">{{ $user->email }}</h5>
                                                    <p class="mb-0">Actif | <span class="text-info">{{ isset($user->active_until) ? $user->active_until->format('Y-m-d') : '' }}</span></p>
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
                                                <div class="collapse mt-2" id="collapse_{{ $user->id }}">
                                                    <div class="d-flex flex-row justify-content-between flex-wrap" >
                                                        @foreach($user->abonnements as $abo)
                                                            <div class="card card-categorie bg-light border">
                                                                <div class="card-body">
                                                                    <p class="m-0">
                                                                        <strong>Catégorie:</strong> <span class="{{ $abo['published'] ? 'text-danger' : '' }}">{{ $abo['title'] }}{{ $abo['published'] ? '*' : '' }}</span>
                                                                    </p>
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
        </div>
        <div class="col-4 publication-col">
            <div class="publication-card ">
                <div class="card mb-2">
                    <div class="card-body">

                        <h3>Tester abo et date</h3>
                        <form action="{{ url('backend/abos') }}" method="POST" class="mb-2">{!! csrf_field() !!}
                            <div class="form-group">
                                @if(!$users->isEmpty())
                                    <select class="custom-select" name="user_id">
                                        @foreach($users as $user)
                                            <option {{ isset($params['user_id']) && $params['user_id'] == $user->id ? 'selected' : '' }} value="{{ $user->id }}">
                                                {{ $user->name }} - {{ $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control datePicker" value="{{ $params['date'] ?? '' }}" name="date" placeholder="date">
                            </div>
                            <div class="form-group">
                                <select name="cadence" class="form-control">
                                    <option {{ isset($params['cadence']) && $params['cadence'] == 'daily' ? 'selected' : '' }} value="daily">Daily</option>
                                    <option {{ isset($params['cadence']) && $params['cadence'] == 'weekly' ? 'selected' : '' }} value="weekly">Weekly</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-info btn-sm" type="submit">Tester</button>
                            </div>
                        </form>
                    </div>
                </div>
                <p><small class="text-danger">Destiné à publication *</small></p>
                <p><small class="">Daily - Alerte chaque jour</small></p>
                <p><small class="">Weekly - Alerte que le vendredi pour toute la semaine</small></p>
            </div>
        </div>

    </div>
</div>
@stop
