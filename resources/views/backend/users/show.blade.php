@extends('layouts.app')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row page-title">
            <div class="col-md-12">
                <h3 class="mb-1 mt-0">Editer</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mt-3">
                            <h5 class="mt-2 mb-0">{{ $user->name }}</h5>
                            <h6 class="text-muted font-weight-normal mt-2 mb-0">Abonnement actif au</h6>
                            <h6 class="text-{{ $user->valid ? 'success' : 'warning' }} font-weight-normal mt-1 mb-4">{{ isset($user->active_until) ? $user->active_until->format('Y-m-d') : '' }}</h6>
                        </div>

                        <div class="mt-3 pt-2 border-top">
                            <h4 class="mb-3 font-size-15">Données</h4>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0 text-muted">
                                    <tbody>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Adresse</th>
                                        <td>{!! $user->adresse !!}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">NPA/Ville</th>
                                        <td>{{ $user->npa }} {{ $user->ville }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->

            </div>

            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <h3>Codes</h3>
                        @if(!$user->codes->isEmpty())
                            <table class="table table-borderless mb-0 text-muted">
                                <tbody>
                                @foreach($user->codes as $code)
                                    <tr>
                                        <th scope="row">Date</th>
                                        <td>{{ $code->valid_at->format('Y-m-d') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Code</th>
                                        <td>{{ $code->code }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @endif
                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>

    </div>

@stop
