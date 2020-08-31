@extends('layouts.master')
@section('content')

    <div class="decisions-wrapper">

        <aside class="decisions-aside">
            @if(!$parents->isEmpty())
                <div class="accordion sidebar-list" id="SidebarList">
                    @foreach($parents as $parent)
                        <div>
                            <a class="parent-link" data-toggle="collapse" data-target="#cat_{{ $parent->id }}">
                                <span>{{ $parent->nom }}</span><i class="fas fa-caret-right"></i>&nbsp;
                            </a>
                            <div id="cat_{{ $parent->id }}" class="collapse" aria-labelledby="cat_{{ $parent->id }}" data-parent="#SidebarList">
                                @if(!$parent->categories->isEmpty())
                                    @foreach($parent->categories as $categorie)
                                        <a class="child-link" href="{{ secure_url('categorie/'.$categorie->id) }}">{{ $categorie->name }}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </aside>
        <section class="decisions-section">

            <div class="decisions-section-options">
                <!-- Contenu -->
                @yield('options')
                <!-- Fin contenu -->
            </div>

            <div class="decision-content">
                <!-- Contenu -->
                @yield('section')
                <!-- Fin contenu -->
            </div>

        </section>
    </div><!-- wrapper -->

@endsection
