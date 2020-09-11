@extends('layouts.app')
@section('content')

<div class="container-fluid mt-4">
    <div class="row page-title">
        <div class="col-md-12">
            <h3 class="mb-1 mt-0">Alertes Email</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">

                    <div class="d-flex flex-row justify-content-between">
                        <h3 class="d-flex">Tester abo et date</h3>
                        <div>
                            <small class="text-danger">Destiné à publication *</small> |
                            <small class="">Daily - Alerte chaque jour</small> |
                            <small class="">Weekly - Alerte que le vendredi pour toute la semaine</small>
                        </div>
                    </div>

                    <form action="{{ secure_url('backend/user/alerte') }}" method="POST" class="row">@csrf
                        <div class="col">
                            @if(!$users->isEmpty())
                                <select class="custom-select select2" name="user_id">
                                    <option value="">Choix abonné</option>
                                    @foreach($users as $user)
                                        <option {{ isset($params['user_id']) && $params['user_id'] == $user->id ? 'selected' : '' }} value="{{ $user->id }}">
                                            {{ $user->name }} - {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col">
                            <input type="text" class="form-control datePicker" value="{{ $params['date'] ?? '' }}" name="date" placeholder="date">
                        </div>
                        <div class="col">
                            <select name="cadence" class="form-control">
                                <option value="">Cadence</option>
                                <option {{ isset($params['cadence']) && $params['cadence'] == 'daily' ? 'selected' : '' }} value="daily">Daily</option>
                                <option {{ isset($params['cadence']) && $params['cadence'] == 'weekly' ? 'selected' : '' }} value="weekly">Weekly</option>
                            </select>
                        </div>
                        <div class="col text-right">
                            <button class="btn btn-primary" type="submit">Tester</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
           @if(!empty($alertes))
               @foreach(array_chunk($alertes,2) as $row)
                <div class="col">
                    @foreach($row as $alert)
                        <div class="card">
                            <div class="card-body">
                               {!! $alert !!}
                            </div>
                        </div>
                    @endforeach
                </div>
                @endforeach
           @endif
    </div>

</div>
@stop
