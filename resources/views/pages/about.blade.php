@extends('layouts.master')
@section('content')

    <section class="about-four">
        <div class="container">
            <div class="about-four__image wow fadeInRight" data-wow-duration="1500ms">
                <img src="{{ secure_asset('images/about-4-1.png') }}" alt="">
            </div><!-- /.about-four__image -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-four__content">
                        <div class="block-title">
                            <p>A propos</p>
                            <h3>Le droit pour le praticien</h3>
                        </div><!-- /.block-title -->
                        <div class="about-four__highlite-text">
                            <p>Complément indispensable de la collection Le droit pour le praticien, ce site reprend l’ensemble des résumés
                                de jurisprudence publiés annuellement par la faculté depuis 2007.</p>
                        </div><!-- /.about-four__highlite-text -->
                        <p>
                            Près de 25 domaines du droit sont abordés. Chaque thème est présenté de manière systématique et des liens directs sur les arrêts fédéraux
                            sont inclus. Une recherche ciblée par mots-clés ou articles de loi est également proposée. Ce site permet par ailleurs de consulter
                            la jurisprudence récente du Tribunal fédéral organisée par thèmes principaux.
                        </p>
                        <div>
                            <blockquote>
                                <strong>L'achat du livre Le droit pour le praticien</strong> vous donne droit à un code d'accès vous permettant
                                la création d'un compte utilisateur sur le site et la consultation des articles.
                            </blockquote>
                        </div>
                    </div><!-- /.about-four__content -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>

@stop
