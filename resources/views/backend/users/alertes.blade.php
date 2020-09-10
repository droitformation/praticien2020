@extends('layouts.app')
@section('content')

<div class="container-fluid mt-4">
    <div class="row page-title">
        <div class="col-md-10">
            <h3 class="mb-1 mt-0">Alertes Email</h3>
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

        </div>
        <div class="col-4 publication-col">
            <div class="publication-card ">
                <div class="card mb-2">
                    <div class="card-body">

                        <h3>Tester abo et date</h3>
                        <form action="{{ url('backend/alertes') }}" method="POST" class="mb-2">{!! csrf_field() !!}
                            <div class="form-group">
                                @if(!$users->isEmpty())
                                    <select class="custom-select select2" name="user_id">
                                        <option>Choix abonné</option>
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
                            <div class="form-group text-right">
                                <button class="btn btn-primary" type="submit">Tester</button>
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
