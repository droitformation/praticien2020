@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            @include('arrets.partials.arret', ['arret' => $arret])
        </div>
    </div>
@endsection
