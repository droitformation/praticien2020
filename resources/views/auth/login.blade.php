@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="block-title-login text-center">
                <h3>Login</h3>
            </div><!-- /.block-title-two -->
            <div class="card">
                <div class="card-body pt-5">

                    <form method="POST" action="{{ route('login') }}" class="contact-form-validated contact-one__form contact-one__form-login">@csrf

                        @include('partials.errors')

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
                            <div class="col-md-8">
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>
                            <div class="col-md-8">
                                <input id="password" type="password" name="password" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">{{ __('Se souvenir de moi') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="thm-btn contact-one__btn">{{ __('Login') }}</button>
                            </div>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="text-muted password-forgotten" href="{{ route('password.request') }}">{{ __('Mot de passe oublié?') }}</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
