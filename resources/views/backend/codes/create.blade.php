@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row page-title">
        <div class="col-md-12">
            <h3 class="mb-0 mt-0"><a href="{{ secure_url('backend/codes') }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp; Retour</a></h3>
        </div>
    </div>

    <form id="codeForm" action="{{ secure_url('backend/code') }}" method="post" class="parsley" novalidate="">@csrf
        <div class="row" id="app">
            <div class="col-6">

                <div class="card">
                    <div class="card-body">
                        <h3 class="header-title mt-0 mb-4">Nouveau Code</h3>

                        <div class="form-group">
                            <label for="date">Code</label>
                            <code-component></code-component>
                        </div>

                        <div class="form-group">
                            <label for="date">Date de validité</label>
                            <input name="valid_at" class="form-control datePicker" type="text" placeholder="">
                        </div>

                        <button class="btn btn-primary ml-1 mt-0" type="submit">Enregistrer</button>
                    </div>
                </div>

            </div><!-- end col-->
        </div>
        <!-- end row-->
    </form>
</div>

@endsection
