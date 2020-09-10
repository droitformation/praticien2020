@extends('layouts.app')
@section('content')

<div class="container-fluid mt-4">
    <div class="row page-title">
        <div class="col-md-12">
            <h3 class="mb-1 mt-0">Utilisateurs</h3>
            <h5 class="text-danger">Abos inactifs</h5>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div id="user-list">

                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="search form-control" placeholder="recherche">
                </div>

                <div class="list">
                    @foreach($users->chunk(2) as $row)
                        <div class="row">
                            @foreach($row as $i => $user)
                                <div class="col-6">
                                    @include('backend.users.partials.card', ['user' => $user])
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

            </div><!-- col -->
        </div><!-- row -->

    </div>
</div>
@stop
