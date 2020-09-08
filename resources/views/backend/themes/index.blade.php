@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-10">
                <h3 class="mb-0 mt-0"><a href="{{ secure_url('backend/theme') }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp; Retour</a></h3>
            </div>
            <div class="col-md-2 text-right">
                <a href="{{ secure_url('backend/theme/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> &nbsp;Ajouter</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="header-title mt-0 mb-4">Domaines</h3>

                        @if(!$themes->isEmpty())
                            <table id="arret_list" class="table table-striped table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Principal</th>
                                    <th class="text-right" width="80px">Gestion</th>
                                    <th class="text-right" width="30px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($themes as $theme)
                                    <tr>
                                        <td class="font-weight-bold font-size-15">
                                            <a class="{{ $theme->parent_id > 0 ? 'text-muted' : 'text-primary' }}" href="{{ secure_url('backend/theme/'.$theme->id) }}">{{ $theme->name }}</a>
                                        </td>
                                        <td>{{ $theme->parent_id > 0 ? 'NON' : 'OUI' }}</td>
                                        <td class="text-right">
                                            <a class="btn btn-sm btn-primary btn-block mr-1" href="{{ secure_url('backend/theme/'.$theme->id) }}"><i class="fas fa-edit"></i></a>
                                        </td>
                                        <td class="text-right">
                                            @if($theme->can_be_deleted)
                                                <form action="{{ url('backend/theme/'.$theme->id) }}" method="POST" class="d-flex flex-row justify-content-between align-items-center">
                                                    <input type="hidden" name="_method" value="DELETE">@csrf
                                                    <button data-what="supprimer" data-action="{{ $theme->name }}" class="btn btn-danger btn-sm btn-block deleteAction ml-1">x</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif

                        @if($themes instanceof \Illuminate\Pagination\LengthAwarePaginator )
                            {!! $themes->links() !!}
                        @endif

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </div>

@stop
