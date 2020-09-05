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
                    <div class="row">
                        <div class="col-8">

                            <div class="card">
                                <div class="card-body">
                                    <h3 class="header-title mt-0 mb-4">Nouvel arrêt</h3>

                                        <div class="form-group">
                                            <label for="title">Édition de l'ouvrage<span class="text-danger">*</span></label>
                                            <select class="form-control custom-select" @change="update" v-model="status">
                                                @if(isset($editions))
                                                    @foreach($editions as $start => $end)
                                                        <option value="{{ $start.'-'.$end }}">{{ $start.'/'.$end }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="title">Titre<span class="text-danger">*</span></label>
                                            <input type="text" name="title" required="" placeholder="Titre de l'arrêt" class="form-control" id="title">
                                        </div>

                                        <div class="form-group">
                                            <label for="atf">Lien ATF</label>
                                            <input type="text" name="meta[atf]" placeholder="https://www.bger.ch..." class="form-control" id="atf">
                                        </div>

                                        <div class="form-group">
                                            <label for="emailAddress">Contenu<span class="text-danger">*</span></label>
                                            <textarea class="form-control redactor"></textarea>
                                        </div>

                                </div>
                            </div>

                        </div><!-- end col-->
                        <div class="col-4" id="app">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-4">Valider</h4>

                                    <publication-component></publication-component>

                                    <div class="form-group text-right mb-0 mt-4">
                                        <button class="btn btn-primary btn-block mr-1" type="submit">Enregistrer</button>
                                    </div>

                                    published_at title content
                                    status slug'
                                    guid'
                                    lang'
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
