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

                        <div class="block-title mb-4">
                            <p>Domaines &nbsp;<a href="#" data-toggle="modal" data-target="#question"><i class="fas fa-question-circle"></i></a></p>
                        </div><!-- /.block-title -->

                        <div class="modal fade" id="question" tabindex="-1" aria-labelledby="question" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Explications</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Recevez les nouveaux arrêts rendus par le TF correspondants aux rubriques choisies avec ou sans mots clés. </p>
                                        <p>Vous pouvez aussi choisir de ne recevoir que les arrêts correspondants à certains mots clés en les indiquant dans la rubrique "Général".</p>
                                        <p>Les mots clés recherchés doivent être séparés par virgules. Ils peuvent être sous la forme d'un groupe de mots entre guillemets,
                                            exemple => <strong>"Grand Conseil de Genève"</strong> ou seulement d'un mot, exemple => <strong>CPC</strong>. Les arrêts trouvés sont ceux qui comprennent
                                            l'ensemble des mots clés séparés par virgules. Plusieurs listes de mots clés peuvent être créées sous la même rubrique.
                                            Il est possible de mettre les mots clés en plusieurs langues afin d'obtenir plus de résultats.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

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
