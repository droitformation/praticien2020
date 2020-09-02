@extends('layouts.master')
@section('content')

    <section class="blog-one blog-details-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="about-four__content">
                        <div class="block-title">
                            <p>Compte expiré</p>
                            <h3>Re-activation de votre compte</h3>
                        </div><!-- /.block-title -->
                    </div>
                    <div class="comment-form">
                        <form method="POST" action="{{ secure_url('activate') }}" class="contact-form-validated contact-one__form" novalidate="novalidate">@csrf
                            <div class="row mb-1">
                                <div class="col-lg-12">
                                    <div class="form-wrapper">
                                        <i class="fas fa-tag"></i>
                                        <input type="text" class="code-input" name="code" required placeholder="Code d'accès">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-lg-12">
                                    <input type="email" name="email" required placeholder="Email">
                                </div>
                                <div class="col-lg-12">
                                    <input type="password" name="password" required placeholder="Mot de passe">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-lg-12">
                                    <button class="thm-btn contact-one__btn" type="submit">Envoyer</button>
                                </div><!-- /.col-lg-12 -->
                            </div>
                        </form><!-- /.contact-one__form -->
                    </div><!-- /.comment-form -->
                </div><!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="sidebar__single">
                            <h3 class="sidebar__title">Obtenir un Code</h3>
                        </div><!-- /.sidebar__single -->
                        <div class="sidebar__single">
                            <img width="80%" src="{{ secure_asset('images/about-4-1.png') }}" alt="">
                            <p>L’achat du livre Le droit pour le praticien vous donne droit à un code d’accès vous permettant
                                la création d’un compte utilisateur sur le site et la consultation des articles.</p>
                            <a href="https://publications-droit.ch" class="thm-btn contact-one__btn mt-4" type="submit">Acheter</a>
                        </div><!-- /.sidebar__single -->

                    </div><!-- /.sidebar -->
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>

@stop
