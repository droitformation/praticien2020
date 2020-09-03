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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title mt-0 mb-4">Édition 2018/2019</h4>

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
                                                <td>{{ $arret->title }}</td>
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

        </div> <!-- container-fluid -->
    </div> <!-- content -->

@stop
