@extends('layouts.app')
@section('content')

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="row pt-5">

            <div class="col-lg-4">

                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <h5 class="font-size-18 mt-0">Arrêts résumés</h5>
                                <p class="text-muted mb-0">Arrêts provenant de l'ouvrage "Le droit pour le paricien"</p>
                                <a href="{{ secure_url('backend/arret') }}" class="btn btn-primary px-sm-4 mt-4 btn-block">Voir</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">

                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <h5 class="font-size-18 mt-0">Décision du TF</h5>
                                <p class="text-muted mb-0">Jurisprudence du TF récupéré automatiquement</p>
                                <a href="{{ secure_url('backend/decisions') }}" class="btn btn-info px-sm-4 mt-4 btn-block">Voir</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">

                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <h5 class="font-size-18 mt-0">Alertes email</h5>
                                <p class="text-muted mb-0">Envois automatiques aux abonnés</p>
                                <a href="{{ secure_url('backend/abos') }}" class="btn btn-secondary px-sm-4 mt-4 btn-block">Voir</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

@stop
