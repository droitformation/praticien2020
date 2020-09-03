@extends('layouts.app')
@section('content')

    <div class="content-page">
        <div class="content">

            <div class="container-fluid">
                <div class="row page-title">
                    <div class="col-md-12">
                        <h4 class="mb-1 mt-0">Éditions "Le droit pour le praticien"</h4>
                    </div>
                </div>

                <div class="row">

                    @if(!$years->isEmpty())
                        @foreach($years as $year => $count)
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <a href="{{ secure_url('backend/arret/year/'.$year) }}">
                                            <div class="media p-3">
                                                <div class="media-body">
                                                <span class="text-muted text-uppercase font-size-12 font-weight-bold">
                                                    <span class="text-primary">{{ $count }}</span>
                                                    <span class="text-muted">arrêts</span>
                                                </span>
                                                    <h2 class="mb-0">{{ $year }}</h2>
                                                </div>
                                                <div class="align-self-center">
                                                    <h2><i class="fas fa-book text-danger"></i></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div><!-- end col-->
                        @endforeach
                    @endif

                </div><!-- end row-->
            </div>

        </div> <!-- container-fluid -->
    </div> <!-- content -->

@stop
