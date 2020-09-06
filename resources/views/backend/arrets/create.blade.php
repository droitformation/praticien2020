@extends('layouts.app')
@section('content')

    <div class="content-page">
        <div class="content">

            <div class="container-fluid">
                <div class="row page-title">
                    <div class="col-md-12">
                        <h3 class="mb-0 mt-0"><a href="{{ secure_url('backend/arret') }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp; Retour</a></h3>
                    </div>
                </div>

                <form action="{{ secure_url('backend/arret') }}" method="post" class="parsley-examples" novalidate="">
                    <div class="row" id="app">
                        <div class="col-8">

                            <div class="card">
                                <div class="card-body">
                                    <h3 class="header-title mt-0 mb-4">Nouvel arrêt</h3>

                                        <div class="form-group">
                                            <label for="title">Édition de l'ouvrage<span class="text-danger">*</span></label>
                                            <select class="form-control custom-select">
                                                @if(isset($editions))
                                                    @foreach($editions as $start => $end)
                                                        <option {{ $loop->first ? 'selected' : '' }} value="{{ $start.'-'.$end }}">{{ $start.'/'.$end }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <theme-component :themes="{{ $themes }}"></theme-component>

                                        <hr>

                                        <atf-component></atf-component>

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
                                            <input name="meta[termes_rechercher]" class="form-control" type="text" placeholder="numero:loi:alinéa:chiffre:lettre">
                                        </div>

                                        <div class="form-group">
                                            <label for="emailAddress">Contenu<span class="text-danger">*</span></label>
                                            <textarea class="form-control redactor"></textarea>
                                        </div>

                                </div>
                            </div>

                        </div><!-- end col-->
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-4">Publier</h4>

                                    <publication-component></publication-component>

                                    <div class="form-group mb-0 mt-4 d-flex flex-row justify-content-between">
                                        <button class="btn btn-outline-primary btn-block mr-1" type="submit">Enregistrer brouillon</button>
                                        <button class="btn btn-primary btn-block ml-1 mt-0" type="submit">Publier</button>
                                    </div>

                                    slug
                                    guid
                                    lang
                                    metas
                                    year
                                    themes
                                </div>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <!-- end row-->
                </form>
            </div>

        </div> <!-- container-fluid -->
    </div> <!-- content -->
@endsection
