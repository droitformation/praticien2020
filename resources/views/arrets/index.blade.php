@extends('layouts.master')
@section('content')
    <div class="container">

        <div class="py-5">
            @include('arrets.partials.search')
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
