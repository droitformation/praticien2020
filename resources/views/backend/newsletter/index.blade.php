@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-10">
                <h3 class="mb-0 mt-0"><a href="{{ secure_url('backend/theme') }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp; Retour</a></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h3>Prochaine newsletter</h3>
                        <p><strong><i class="fas fa-calendar-day"></i> &nbsp;{{ $week }}</strong></p>
                        <p class="text-muted mb-0">Décisions du TF à publication</p>
                    </div> <!-- end card body-->
                </div> <!-- end card -->

            </div><!-- end col-->

            <div class="col-8">
                {!! $newsletter !!}
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </div>

@stop
