@extends('layouts.master')
@section('content')
    <div class="container">

        <div class="py-5">
            <div class="row">
                <div class="col-lg-12">

                    <h3>Recherche</h3>

                    <div class="row">
                        <div class="col-lg-4">
                            <form action="{{ secure_url('searchTerm') }}" method="POST">@csrf
                                {!! Honeypot::generate('my_name', 'my_time') !!}
                                <div class="input-group mb-3">
                                    <input class="form-control" name="term" type="text" placeholder="Termes...">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">Ok</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-8">
                            <form action="{{ secure_url('searchLoi') }}" method="POST">@csrf
                                {!! Honeypot::generate('my_name', 'my_time') !!}
                                <div class="input-group mb-3">
                                    <input class="form-control" name="params[article]" type="text" placeholder="Article">
                                    <input class="form-control" name="params[loi]" type="text" placeholder="Loi">
                                    <input class="form-control" name="params[alinea]" type="text" placeholder="Alinéa">
                                    <input class="form-control" name="params[chiffre]" type="text" placeholder="Chiffre">
                                    <input class="form-control" name="params[lettre]" type="text" placeholder="Lettre">
                                    @if(!empty($editions))
                                        <select class="custom-select" name="year">
                                            <option selected>Édition</option>
                                            @foreach($editions as $edition)
                                                <option value="{{ $edition }}">{{ $edition }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">Ok</button>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    @if(!$parents->isEmpty())
                        <div class="py-3 d-flex flex-row justify-content-between flex-wrap themes-content-list">

                            @foreach($parents->chunk(11) as $col)
                                <div class="arret-bloc-wrapper">
                                    @foreach($col as $parent)
                                        <a href="{{ secure_url('theme/'.$parent->slug) }}" class="arret-bloc">{{ $parent->name }}</a>
                                    @endforeach
                                </div>
                            @endforeach

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
