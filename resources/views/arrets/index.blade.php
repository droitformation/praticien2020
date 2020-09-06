@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="py-5 d-flex flex-row justify-content-between flex-wrap">
                    @if(!$parents->isEmpty())
                        @foreach($parents as $parent)
                            <a href="{{ secure_url('theme/'.$parent->slug) }}" class="arret-bloc">{{ $parent->name }}</a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
