@extends('layouts.master')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-8 py-5">
                <div class="block-title">
                    <h3>{{ $theme->name }}</h3>
                </div>

                @if(!$arrets->isEmpty())
                    @foreach($arrets as $arret)
                        @include('arrets.partials.arret', ['arret' => $arret])
                    @endforeach
                @else
                    <p class="mt-4">Rien dans <strong>{{ $subtheme->name ?? $theme->name  }}</strong> {{ $edition ?? '' }}</p>
                @endif

                @if($arrets instanceof \Illuminate\Pagination\LengthAwarePaginator )
                    {!! $arrets->links() !!}
                @endif

            </div>
            <div class="col-lg-4 py-5">
                <div class="sidebar position-relative">

                    <a class="reset" href="{{ secure_url('theme/'.$theme->slug) }}">Tous</a>

                    @if(\Request::is('subtheme/*'))
                        <p class="sidebar_link sidebar_link_main">
                            <a href="{{ secure_url('theme/'.$theme->slug) }}"><i class="fas fa-arrow-alt-circle-left"></i> &nbsp;{{ $theme->name }}</a>
                        </p>
                    @endif

                    @if(isset($editions))
                        <div class="mb-4 mt-2">
                            <h3 class="sidebar__title mb-4">Édition</h3>
                            @foreach($editions as $start => $end)
                                <a class="btn btn-xs thm-btn thm-btn-small {{ Request::is('theme/'.$theme->slug.'/'.$start.'-'.$end) ? 'active' : '' }}"
                                   href="{{ secure_url('theme/'.$theme->slug.'/'.$start.'-'.$end) }}">{{ $start.'/'.$end }}</a>
                            @endforeach
                        </div>
                    @endif

                    <div class="sidebar__single">
                        <h3 class="sidebar__title">Sous-Thème</h3>
                    </div><!-- /.sidebar__single -->
                    <div class="sidebar__single">
                        @if(!$theme->subthemes->isEmpty())
                            @foreach($theme->subthemes as $sub)
                                <p class="sidebar_link"><a class="{{ Request::is('subtheme/'.$sub->slug.(isset($edition) ? '/'.$edition : '')) ? 'active' : '' }}"
                                    href="{{ secure_url('subtheme/'.$sub->slug.(isset($edition) ? '/'.$edition : '')) }}">{{ $sub->name }}</a></p>
                            @endforeach
                        @endif
                    </div><!-- /.sidebar__single -->
                </div><!-- /.sidebar -->
            </div>

        </div>
    </div>
@endsection
