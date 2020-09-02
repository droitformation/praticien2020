@extends('layouts.master')
@section('content')

<section class="blog-one blog-details-page" id="app">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">

                <div class="card card-shadow">
                    <div class="card-body">
                        <div class="block-title">
                            <p>Compte</p>
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

                <div class="card card-shadow">
                    <div class="card-body">
                        <a href="{{ secure_url('abos') }}" class="btn btn-sm btn-block btn-dark">jurisprudence TF - Alertes par e-mail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">

                <div class="card">
                    <div class="card-body">
                        <div class="block-title mb-4">
                            <p>Données</p>
                        </div>
                        <form method="POST" action="{{ secure_url('update') }}" class="contact-form-validated contact-one__form" novalidate="novalidate">@csrf
                            <div class="row mb-1">
                                <div class="col-lg-12"><input type="email" name="email" value="{{ $user->email }}" required placeholder="Email"></div>
                            </div>
                            <div class="divider div-transparent div-arrow-down"></div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" name="first_name" value="{{ $user->first_name }}" required placeholder="Prénom">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="last_name" value="{{ $user->last_name }}" required placeholder="Nom">
                                </div>
                                <div class="col-lg-12">
                                    <input type="text" name="adresse" value="{{ $user->adresse }}" required placeholder="Adresse">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="npa" value="{{ $user->npa }}" placeholder="NPA">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="ville" value="{{ $user->ville }}" required placeholder="Ville">
                                </div>
                                <div class="col-lg-12">
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button class="thm-btn contact-one__btn" type="submit">Enregistrer</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
