@extends('layouts.master')
@section('content')

<section class="blog-one blog-details-page" id="app">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">

                <div class="card card-shadow">
                    <div class="card-body">
                        <div class="block-title">
                            <p>Alertes e-mail</p>
                            <h5>Fréquence des envois</h5>
                        </div>
                        <cadence-component cadence="{{ $user->cadence }}" user_id="{{ $user->id }}"></cadence-component>
                    </div>
                </div>

                <div class="card card-shadow">
                    <div class="card-body">
                        <div class="block-title">
                            <p>Informations</p>
                            <h5>{{ $user->name }}</h5>
                        </div>
                       <div>
                           <p>Compte valide jusqu'au <span class="text-success">{{ $user->active_until->format('d/m/y') }}</span></p>
                           <dt>
                               {!! $user->name != $user->email ? '<dt>Email</dt><dd>'.$user->email.'</dd>' : '' !!}
                               {!! $user->adresse ? '<dt>Adresse</dt><dd>'.$user->adresse.'</li>' : '' !!}
                               {!! $user->npa || $user->ville ? '<dt>NPA/Ville</dt><dd>'.$user->npa.' '.$user->ville.'</dd>' : '' !!}
                           </dt>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">


                    <?php
                            echo '<pre>';
                            print_r($user->abos->toArray());
                            echo '</pre>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
