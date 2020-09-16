@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row page-title">
        <div class="col-md-10">
            <h3 class="mb-0 mt-0"><a href="{{ secure_url('backend/codes') }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp; Retour</a></h3>
        </div>
        <div class="col-md-2 text-right">
            @if($code->can_be_deleted)
                <form action="{{ url('backend/code/'.$code->id) }}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">@csrf
                    <button data-what="supprimer" data-action="{{ $code->name }}" class="btn btn-danger btn-sm deleteAction"><i class="fas fa-exclamation-circle"></i> &nbsp;Supprimer</button>
                </form>
            @endif
        </div>
    </div>

    <form id="codeForm" action="{{ secure_url('backend/code/'.$code->id) }}" method="post" class="parsley" novalidate="">@csrf
        <input type="hidden" name="_method" value="PUT">
        <input name="id" value="{{ $code->id }}" type="hidden">

        <div class="row" id="app">
            <div class="col-6">

                <div class="card">
                    <div class="card-body">
                        <h3 class="header-title mt-0 mb-4">Editer</h3>

                        <div class="form-group">
                            <label for="date">Code</label>
                            <input name="code" class="form-control" value="{{ $code->code }}" disabled type="text" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="date">Date de validité</label>
                            <input name="valid_at" class="form-control datePicker" value="{{ $code->valid_at }}" type="text" placeholder="">
                        </div>

                        @if($code->user)
                            <div class="form-group bg-light px-4 py-2">
                                <label class="mb-0" for="date">Lié à</label>
                                <a href="{{ secure_url('user/'. $code->user->id) }}">{{ $code->user->name }}</a>
                            </div>
                        @endif

                        <p class="text-right mb-0"><button class="btn btn-primary ml-1 mt-0" type="submit">Enregistrer</button></p>
                    </div>
                </div>

            </div><!-- end col-->
        </div>
        <!-- end row-->
    </form>
</div>

@endsection
