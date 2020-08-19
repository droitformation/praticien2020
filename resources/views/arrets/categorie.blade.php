@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 py-5">
                        <div class="block-title">
                            <h3>{{ $categorie->name }}</h3>
                        </div>

                        @if(!$arrets->isEmpty())
                            @foreach($arrets as $arret)
                                @include('arrets.partials.arret', ['arrets' => $arret])
                            @endforeach
                        @endif

                        @if($arrets instanceof \Illuminate\Pagination\LengthAwarePaginator )
                            {!! $arrets->links() !!}
                        @endif

                    </div>
                    <div class="col-lg-4 py-5">
                        <div class="sidebar">
                            @if(\Request::is('subcategorie/*'))
                            <p class="sidebar_link sidebar_link_main">
                                <a href="{{ secure_url('categorie/'.$categorie->slug) }}"><i class="fas fa-arrow-alt-circle-left"></i> &nbsp;{{ $categorie->name }}</a>
                            </p>
                            @endif
                            <div class="sidebar__single">
                                <h3 class="sidebar__title">Sous-Catégories</h3>
                            </div><!-- /.sidebar__single -->
                            <div class="sidebar__single">
                                @if(!$categorie->subcategory->isEmpty())
                                    @foreach($categorie->subcategory as $subcategory)
                                        <p class="sidebar_link"><a href="{{ secure_url('subcategorie/'.$subcategory->slug) }}">{{ $subcategory->name }}</a></p>
                                    @endforeach
                                @endif
                            </div><!-- /.sidebar__single -->
                        </div><!-- /.sidebar -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
