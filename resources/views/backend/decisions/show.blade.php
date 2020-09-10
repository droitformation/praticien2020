@extends('layouts.app')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row page-title">
            <div class="col-md-12">
                <h3 class="mb-0 mt-0">
                    @if(isset($dates))
                        <a href="{{ secure_url('backend/archive/'.$dates->first()->publication_at->year) }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp; Retour</a>
                    @else
                        <a href="{{ secure_url('backend/archive') }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp; Retour</a>
                    @endif
                </h3>
            </div>
        </div>

        <!-- Decision -->

        <div class="row">

            @if(isset($dates) && !$dates->isEmpty())
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-4">Décisions du {{ $dates->first()->publication_at->formatLocalized('%d %B %Y') }}</h4>
                            <ul class="list-group list-group-flush  text-muted">
                                @foreach($dates as $date)
                                    <li class="list-group-item">
                                        <a class="d-flex flex-row justify-content-between" href="{{ secure_url('backend/decision/'.$date->id.'/'.$year) }}">
                                           <span>{{ $date->numero }}</span> <span class="text-muted">{{ $date->decision_at->format('Y-m-d') }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-{{ isset($dates) ? '9' : '12' }}">
                <div class="card">
                    <div class="card-body">

                        @if(isset($decision))
                            <div class="decision-details">
                                <div class="dates">
                                    <div><strong class="block">Référence </strong>{{ $decision->numero }}</div>
                                    <div><strong class="block">Publication </strong>{{ $decision->publication_at->format('d/m/Y') }}</div>
                                    <div><strong class="block">Décision </strong>{{ $decision->decision_at->format('d/m/Y') }}</div>
                                    <div><strong class="block">Langue </strong>{{ $decision->lang }}</div>
                                </div>
                            </div>
                            <div class="decision-text">{!! $decision->texte !!}</div>
                        @else
                            <p class="text-muted mt-4"><i class="fas fa-arrow-alt-circle-left"></i> &nbsp; Choisir une décision</p>
                        @endif

                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>

        <!-- end Decision -->

    </div>

@stop
