@extends('layouts.master')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12 py-5">
                <div class="block-title">
                    <h3>Résultats pour {{ $term ?? frontendParams($params) }}</h3>
                </div>

                @if(!$arrets->isEmpty())
                    @foreach($arrets as $arret)
                        @include('arrets.partials.arret', ['arret' => $arret])
                    @endforeach
                @else
                    <p class="mt-4">Rien pour <strong>{{ $term }}</strong></p>
                @endif

                @if($arrets instanceof \Illuminate\Pagination\LengthAwarePaginator )
                    {!! $arrets->links() !!}
                @endif

            </div>
        </div>
    </div>

@endsection
