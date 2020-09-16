@extends('layouts.app')
@section('content')

<div class="container-fluid mt-4">
    <div class="row page-title">
        <div class="col-md-10">
            <h3 class="mb-1 mt-0">Utilisateurs</h3>
            <h5 class="text-success">Abos actif</h5>
        </div>
        <div class="col-md-2 text-right">
            <a href="{{ secure_url('backend/user/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> &nbsp;Ajouter</a>
            <a href="{{ secure_url('backend/users/inactive') }}" class="btn btn-warning"><i class="fas fa-exclamation-circle"></i> &nbsp;Inactifs</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            @include('backend.users.partials.list', ['users' => $users])

        </div><!-- col -->
    </div>

</div>
@stop
