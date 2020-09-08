@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row page-title">
        <div class="col-md-12">
            <h3 class="mb-0 mt-0"><a href="{{ secure_url('backend/theme') }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp; Retour</a></h3>
        </div>
    </div>

    <form id="themeForm" action="{{ secure_url('backend/theme') }}" method="post" class="parsley" novalidate="">@csrf
        <div class="row" id="app">
            <div class="col-8">

                <div class="card">
                    <div class="card-body">
                        <h3 class="header-title mt-0 mb-4">Nouveau domaine</h3>

                        <div class="form-group">
                            <label for="title">Parent</label>
                            <select class="form-control custom-select" name="parent_id">
                                <option value="0">Domaine principal</option>
                                @if(isset($parents))
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="termes_rechercher">Nom</label>
                            <input name="name" class="form-control" type="text" placeholder="">
                        </div>

                    </div>
                </div>

            </div><!-- end col-->
            <div class="col-4 publication-col">
                <div class="publication-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-4"><i class="fas fa-bullhorn"></i> &nbsp;Gestion</h4>
                            <button class="btn btn-primary btn-block ml-1 mt-0" type="submit">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </form>
</div>

@endsection
