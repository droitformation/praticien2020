@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center h-100 pt-5">
            @include('arrets.partials.arret', ['arret' => $arret])
        </div>
    </div>
@endsection
