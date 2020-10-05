@extends('layouts.master')
@section('content')

    <div class="container">

       <div class="pt-5">
           <a class="btn btn-sm btn-search" data-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="false" aria-controls="collapseSearch">
              <i class="fas fa-redo"></i> &nbsp;Nouvelle recherche
           </a>
           <div class="collapse mt-4" id="collapseSearch">
               @include('arrets.partials.search')
               <hr>
           </div>
       </div>

        <div class="row">
            <div class="col-lg-12 pt-1 pb-2">
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
