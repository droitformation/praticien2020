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

                        <div id="tab-categories">
                            <div class="nav flex-column nav-pills" id="main-tab-nav" role="tablist" aria-orientation="vertical">
                                @if(!$parents->isEmpty())
                                    @foreach($parents as $parent)
                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="pill" href="#v-pills-{{ $parent->id }}" role="tab" aria-controls="v-pills-{{ $parent->id }}" aria-selected="true">{{ $parent->nom }}</a>
                                    @endforeach
                                @endif
                            </div>

                            @if(!$parents->isEmpty())
                                <div class="tab-content" id="main-tab-content">
                                    @foreach($parents as $parent)
                                        <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="v-pills-{{ $parent->id }}" role="tabpanel" aria-labelledby="v-pills-{{ $parent->id }}-tab">
                                            @if(!$parent->categories->isEmpty())
                                                @foreach($parent->categories as $categorie)
                                                    <?php
                                               /*     echo '<pre>';
                                                    print_r($user->abos);
                                                    print_r(getAboCategorie($user,$categorie->id));
                                                    echo '</pre>';*/

                                                    ?>
                                                    <abo-component :categorie="{{ $categorie }}" :abo="{{ json_encode(getAboCategorie($user,$categorie->id)) }}" user_id="{{ $user->id }}"></abo-component>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
