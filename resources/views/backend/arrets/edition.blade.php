@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row page-title">
        <div class="col-md-10">
            <h3 class="mb-0 mt-0"><a href="{{ secure_url('backend/arret') }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp; Retour</a></h3>
        </div>
        <div class="col-md-2 text-right">
            <a href="{{ secure_url('backend/arret/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> &nbsp;Ajouter</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="header-title mt-0 mb-4">Le droit pour le praticien | <span class="text-primary">Édition {{ $year }}</span></h3>

                    @if(!$arrets->isEmpty())
                        <table id="arret_list" class="table table-striped table-bordered dataTable">
                            <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Edition</th>
                                <th>Thème principal</th>
                                <th class="text-right">Gestion</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($arrets as $arret)
                                <tr>
                                    <td class="font-weight-bold font-size-15">
                                        <a class="text-secondary" href="{{ secure_url('backend/arret/'.$arret->id) }}">{{ $arret->title }}</a></td>
                                    <td>{{ $arret->getMeta('year') }}</td>
                                    <td>{{ $arret->main_theme ? $arret->main_theme->name : ''  }}</td>
                                    <td class="text-right"><a class="btn btn-sm btn-primary" href="{{ secure_url('backend/arret/'.$arret->id) }}"><i class="fas fa-edit"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if($arrets instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {!! $arrets->links() !!}
                    @endif

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
</div>

@stop
