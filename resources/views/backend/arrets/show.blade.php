@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row page-title">
        <div class="col-md-12">
            <h3 class="mb-0 mt-0"><a href="{{ secure_url('backend/arret/year/'.$arret->getMeta('year')) }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp;Retour</a></h3>
        </div>
    </div>

    <form id="arretForm" action="{{ secure_url('backend/arret/'.$arret->id) }}" method="post" class="parsley" novalidate="">@csrf
        <input type="hidden" name="_method" value="PUT">
        <input name="id" value="{{ $arret->id }}" type="hidden">

        <div class="row" id="app">
            <div class="col-8">

                <div class="card">
                    <div class="card-body">
                        <h3 class="header-title mt-0 mb-4">Éditer {{ $arret->numero }}</h3>

                            <div class="form-group">
                                <label for="title">Édition de l'ouvrage<span class="text-danger">*</span></label>
                                <select class="form-control custom-select" required name="metas[year]">
                                    @if(isset($editions))
                                        @foreach($editions as $start => $end)
                                            <option {{ $arret->getMeta('year') == $start.'-'.$end ? 'selected' : '' }} value="{{ $start.'-'.$end }}">{{ $start.'/'.$end }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <theme-component :themes="{{ $themes }}" :current_theme="{{ json_encode($arret->main_theme_select) }}" :current_subthemes="{{ $arret->subthemes_list }}"></theme-component>
                            <hr>
                            <atf-component the_title="{{ $arret->title }}" link="{{ $arret->getMeta('atf') ?? null }}"></atf-component>

                            <div class="form-group">
                                <label for="termes_rechercher">Termes de recherche</label>
                                <a href="#" id="termes_rechercher" class="ml-2"><i class="font-size-15 text-primary fas fa-question-circle"></i></a>
                                <div style="display: none;" id="explications">
                                    <p>Indiquer les dispositions selon la séquence <strong>"numero:loi:alinéa:chiffre:lettre"</strong><br>
                                    Les différentes parties séparées par un double point « : » sans espace. <br>
                                    => <strong>46<span class="text-danger">:</span>LTF<span class="text-danger">:</span>2<span class="text-danger">:</span>1<span class="text-danger">:</span>c</strong><br>
                                    Pour chaque disposition les séparer par une virgule.<br>
                                    => <strong>295:LP:1 <span class="text-danger">,</span> 46:LTF:2 <span class="text-danger">,</span> 98:LTF</strong><br>
                                    S'il n’y a pas d’alinéa continuez la séquence avec le chiffre ou la lettre.</p>
                                </div>
                                <input name="metas[termes_rechercher]" value="{{ $arret->getMeta('termes_rechercher') }}" class="form-control" type="text" placeholder="numero:loi:alinéa:chiffre:lettre">
                            </div>

                            <div class="form-group">
                                <label for="content">Auteur(s)</label>
                                <input name="metas[auteur]" class="form-control" value="{{ $arret->getMeta('auteur') }}" type="text">
                            </div>

                            <div class="form-group">
                                <label for="content">Contenu<span class="text-danger">*</span></label>
                                <textarea name="content" required class="form-control redactor">{!! $arret->content !!}</textarea>
                            </div>

                    </div>
                </div>

            </div><!-- end col-->
            <div class="col-4 publication-col">
                <div class="publication-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-4"><i class="fas fa-bullhorn"></i> &nbsp;Publier</h4>

                            <publication-component the_status="{{ $arret->status }}" the_date="{{ $arret->published_at->format('Y-m-d') }}"></publication-component>

                        </div>
                    </div>
                </div>
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </form>
</div>

@endsection
