@extends('layouts.master')
@section('content')

    <div class="contact-one">
        <div class="container">
            <div class="block-title-two text-center">
                <p>Contact</p>
                <h3>Droit pour le praticien</h3>
            </div><!-- /.block-title-two -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact-one__box">
                        <h3>Adresse</h3>
                        <p>Faculté de droit</p>
                        <p>Avenue du 1er-Mars 26</p>
                        <p>2000 Neuchâtel</p>
                    </div><!-- /.contact-one__box -->
                    <div class="contact-one__box">
                        <h3>Téléphone</h3>
                        <p>+41 32 / 718 12 22 </p>
                    </div><!-- /.contact-one__box -->
                    <div class="contact-one__box">
                        <h3>Email</h3>
                        <p><a href="mailto:droit.formation@unine.ch">droit.formation@unine.ch</a></p>
                    </div><!-- /.contact-one__box -->
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-8">
                    <form action="{{ secure_url('sendMessage') }}" method="POST" class="contact-form-validated contact-one__form">@csrf
                        {!! Honeypot::generate('my_name', 'my_time') !!}
                        <div class="row">
                            <div class="col-lg-6 form-col"><input required id="nom" name="nom" type="text" placeholder="Nom*"></div>
                            <div class="col-lg-6 form-col"><input required id="email" name="email" type="text" placeholder="Email*"></div>
                            <div class="col-lg-12 form-col">
                                <textarea name="remarque" required id="remarque" placeholder="Votre Message*"></textarea>
                            </div>
                            <div class="col-lg-12"><button class="thm-btn contact-one__btn" type="submit">Envoyer</button></div>
                        </div><!-- /.row -->
                    </form><!-- /.contact-one__form -->
                </div><!-- /.col-lg-8 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>

@stop
