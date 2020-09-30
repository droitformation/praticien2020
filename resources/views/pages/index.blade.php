@extends('layouts.master')
@section('content')

    @include('partials.banner')

    <div class="about-cta__wrapper">
        <section class="cta-two mb-4">
            <div class="container">
                <div class="inner-container wow fadeInUp" data-wow-duration="1500ms">
                    <div class="row no-gutters">
                        <div class="col-lg-6">
                            <div class="cta-two__box d-flex flex-row align-items-center px-4">
                                <div class="cta-two__icon m-2"><i class="fas fa-paragraph"></i></div><!-- /.cta-two__icon -->
                                <div class="text-left m-2 ml-4">
                                    <a href="{{ secure_url('arrets') }}">
                                        <h3 class="mb-0">Arrêts principaux résumés</h3>
                                        <span class="text-black-50">Consulter</span>
                                    </a>
                                </div>
                            </div><!-- /.cta-two__box -->
                        </div><!-- /.col-lg-4 -->
                        <div class="col-lg-6">
                            <div class="cta-two__box d-flex flex-row align-items-center px-4">
                                <div class="cta-two__icon m-2"><i class="fas fa-quote-right"></i></div><!-- /.cta-two__icon -->
                                <div class="text-left m-2 ml-4">
                                    <a href="{{ secure_url('decisions') }}">
                                        <h3 class="mb-0">TF - Jurisprudence (depuis 2014)</h3>
                                        <span class="text-white-50">Consulter</span>
                                    </a>
                                </div>
                            </div><!-- /.cta-two__box -->
                        </div><!-- /.col-lg-4 -->
                    </div><!-- /.row -->
                </div><!-- /.inner-container -->
            </div><!-- /.container -->
        </section><!-- /.cta-two -->

        <section class="about-one">
            <div class="container">
                <div class="block-title">
                    <p>A propos</p>
                    <h3>Le droit pour le praticien</h3>
                </div><!-- /.block-title -->

                <div class="row">
                    <div class="col-lg-4">
                        <p class="about-one__highlighted-text">
                            La jurisprudence du Tribunal fédéral, classée par thèmes et consultable par mots-clés.
                        </p><!-- /.about-one__highlighted-text -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                       <p>
                           A l’occasion de sa traditionnelle <strong>Journée annuelle de formation continue</strong> destinée à tous les professionnels du droit,
                           la Faculté de droit de l’Université de Neuchâtel, en collaboration avec le <strong>CEMAJ</strong>, propose une recension des principales
                           mises à jour de la législation, de la doctrine et de la jurisprudence dans les grands domaines du droit.
                       </p>
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <p>
                            Vingt-six domaines du droit sont couverts grâce à la collaboration du corps professoral et intermédiaire de la Faculté.
                            Le site Internet <strong>www.droitpraticien.ch</strong> permet de retrouver en format électronique tous les résumés de jurisprudence des dix dernières années,
                            ainsi que les arrêts récents du Tribunal fédéral, classés par thèmes.
                        </p>
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.about-one -->

        <section class="cta-two mt-80">
            <div class="container">
                <div class="inner-container no-shadow">
                    <div class="row no-gutters">
                        <div class="col-lg-4">
                            <div class="cta-two__box">
                                <div class="cta-two__icon">
                                    <i class="fas fa-clock"></i>
                                </div><!-- /.cta-two__icon -->
                                <h3>TF - Jurisprudence</h3>
                                <p>Liste des dernières décisions<br> du 10 Août 2020</p>
                                <a href="{{ secure_url('decisions') }}" class="thm-btn bg-subscribe">Voir</a><!-- /.thm-btn -->
                            </div><!-- /.cta-two__box -->
                        </div><!-- /.col-lg-4 -->
                        <div class="col-lg-4">
                            <div class="cta-two__box">
                                <div class="cta-two__icon">
                                    <i class="fas fa-book"></i>
                                </div><!-- /.cta-two__icon -->
                                <h3>TF - Jurisprudence</h3>
                                <p class="light">Arrêts destinés à la<br> publication</p>
                                <a href="{{ secure_url('decisions?published=1') }}" class="thm-btn">Voir</a><!-- /.thm-btn -->
                            </div><!-- /.cta-two__box -->
                        </div><!-- /.col-lg-4 -->
                        <div class="col-lg-4">
                            <div class="cta-two__box">
                                <div class="cta-two__icon">
                                    <i class="fas fa-paper-plane"></i>
                                </div><!-- /.cta-two__icon -->
                                <h3>Newsletter</h3>
                                <p>Recevez tous les lundi les<br> arrêts destinés à publication</p>
                                <a data-fancybox="" data-src="#subscribeModal" data-modal="true" href="javascript:;" class="thm-btn bg-subscribe">Inscription</a>
                                <a data-fancybox="" data-src="#unsubscribeModal" data-modal="true" href="javascript:;" class="thm-btn">Désinscription</a>
                            </div><!-- /.cta-two__box -->
                        </div><!-- /.col-lg-4 -->
                    </div><!-- /.row -->
                </div><!-- /.inner-container -->
            </div><!-- /.container -->
        </section><!-- /.cta-two -->

        <div id="subscribeModal" class="p-4" style="display: none; width: 420px;">
            <h3>Newsletter</h3>
            <p>Chaque semaine les arrêts du TF destinés à la publication</p>
            <form action="{{ secure_url('newsletter/subscribe') }}" method="POST">@csrf
                <div class="form-group">
                    <label for="code" class="font-weight-bold">E-mail</label>
                    <input id="code" name="email" class="form-control" type="text" placeholder="">
                </div>
                <div class="d-flex flex-row justify-content-between">
                    <div><button data-fancybox-close="" class="btn btn-light">Annuler</button></div>
                    <div><button type="submit" class="btn btn-secondary">Envoyer</button></div>
                </div>
            </form>
        </div>
        <div id="unsubscribeModal" class="p-4" style="display: none; width: 420px;">
            <h3>Newsletter</h3>
            <p class="text-warning">Désinsciption</p>
            <form action="{{ secure_url('newsletter/unsubscribe') }}" method="POST">@csrf
                <div class="form-group">
                    <label for="code" class="font-weight-bold">E-mail</label>
                    <input id="code" name="email" class="form-control" type="text" placeholder="">
                </div>
                <div class="d-flex flex-row justify-content-between">
                    <div><button data-fancybox-close="" class="btn btn-light">Annuler</button></div>
                    <div><button type="submit" class="btn btn-secondary">Me désinscrire</button></div>
                </div>
            </form>
        </div>


    </div><!-- /.about-cta__wrapper -->

@stop
