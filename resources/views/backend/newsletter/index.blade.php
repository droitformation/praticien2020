@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-10">
                <h3 class="mb-0 mt-0"><a href="{{ secure_url('backend/theme') }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp; Retour</a></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        <h3>Prochaine newsletter</h3>
                        <p><strong><i class="fas fa-calendar-day"></i> &nbsp;{{ $week }}</strong></p>
                        <p class="text-muted mb-0">Décisions du TF à publication</p>
                    </div> <!-- end card body-->
                </div> <!-- end card -->

                    <div class="card">
                        <div class="card-body">
                            @if($annonce)
                                <h4>{{ $annonce->title }}</h4>
                                <form action="{{ secure_url('backend/annonce/'.$annonce->id) }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">@csrf
                                    <a data-fancybox="" data-src="#annonceModal" data-modal="true" href="javascript:;" class="btn btn-primary btn-sm ">Gérer l'annonce</a>
                                    <button data-what="supprimer" data-action="{{ $annonce->title }}" class="btn btn-danger btn-sm deleteAction ml-1"><i class="fas fa-exclamation-circle"></i> Supprimer</button>
                                </form>
                            @else
                                <a data-fancybox="" data-src="#annonceModal" data-modal="true" href="javascript:;" class="btn btn-primary btn-sm ">Créer une annonce</a>
                            @endif
                        </div> <!-- end card body-->
                    </div> <!-- end card -->

                    <div id="annonceModal" class="px-4 py-3 modal-wrapper">

                            @if(isset($annonce))
                                <form id="themeForm" action="{{ secure_url('backend/annonce/'.$annonce->id) }}" method="post">@csrf
                                <input type="hidden" name="_method" value="PUT">
                                <input name="id" value="{{ $annonce->id }}" type="hidden">
                            @else
                                <form action="{{ secure_url('backend/annonce') }}" method="post">@csrf
                            @endif

                            <h3 class="mt-0">Annonce</h3>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="title">Titre</label>
                                        <input name="title" class="form-control" value="{{ $annonce->title ?? '' }}" type="text" placeholder="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="image">Lien vers l'image</label>
                                        <input name="image" class="form-control" value="{{ $annonce->image ?? '' }}" type="text" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="link">Lien</label>
                                <input name="link" class="form-control" value="{{ $annonce->link ?? ''  }}" type="text" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="start_at">Période de publication</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input name="start_at" class="form-control datePicker" value="{{ $annonce->start_at ?? ''  }}" type="text">
                                    </div>
                                    <div class="col-md-6">
                                        <input name="end_at" class="form-control datePicker" value="{{ $annonce->end_at ?? ''  }}" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content">Contenu</label>
                                <textarea name="content" class="form-control redactor">{!! $annonce->content ?? ''  !!}</textarea>
                            </div>

                            <div class="d-flex flex-row justify-content-between">
                                <div><button data-fancybox-close="" class="btn btn-light">Annuler</button></div>
                                <div><button class="btn btn-primary btn-block ml-1 mt-0" type="submit">Enregistrer</button></div>
                            </div>
                        </form>
                    </div>

            </div><!-- end col-->

            <div class="col-7">
                {!! $newsletter !!}
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </div>

@stop
