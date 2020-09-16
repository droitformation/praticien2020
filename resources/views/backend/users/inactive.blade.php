@extends('layouts.app')
@section('content')

<div class="container-fluid mt-4">
    <div class="row page-title">
        <div class="col-md-8">
            <h3 class="mb-1 mt-0">Utilisateurs</h3>
            <h5 class="text-danger">Abos inactifs</h5>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ secure_url('backend/user/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> &nbsp;Ajouter</a>
            <a href="{{ secure_url('backend/user') }}" class="btn btn-success"><i class="fas fa-check"></i> &nbsp;Actifs</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            @include('backend.users.partials.list', ['users' => $users])

        </div>
    </div>

</div>
@stop
