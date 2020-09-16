@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-8">
                <h3 class="mb-0 mt-0"><a href="{{ secure_url('backend/code') }}" class="font-size-15 text-primary"><i class="fas fa-arrow-left"></i> &nbsp; Retour</a></h3>
            </div>
            <div class="col-md-4 text-right">
                <form action="{{ url('backend/code/export') }}" method="POST" class="row">@csrf
                    <div class="col-5 text-right">
                        <a href="{{ secure_url('backend/code/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> &nbsp;Ajouter</a>
                    </div>
                    <div class="col-7">
                       <div class="input-group">
                           <select class="form-control custom-control" name="year">
                               @foreach($years as $y)
                                   <option value="{{ $y->year }}">{{ $y->year }}</option>
                               @endforeach
                           </select>
                           <button class="btn btn-secondary ml-2">Exporter</button>
                       </div>
                    </div>
               </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex flex-row justify-content-between">
                            <h3 class="header-title mt-0 mb-4 d-block">Codes d'accès</h3>
                            <div>
                                @foreach($years as $y)
                                    <a href="{{ secure_url('backend/codes/'.$y->year) }}" class="btn btn-sm btn-light"><i class="fas fa-calendar"></i> &nbsp;{{ $y->year }}</a>
                                @endforeach
                            </div>
                        </div>

                        @if(!$codes->isEmpty())
                            <table id="codes" class="table table-striped table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Date de validité</th>
                                    <th>Année</th>
                                    <th>Status</th>
                                    <th>Lié à</th>
                                    <th class="text-right" width="80px">Gestion</th>
                                    <th class="text-right" width="30px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($codes as $code)
                                    <tr>
                                        <td class="font-weight-bold font-size-15">
                                            <a href="{{ secure_url('backend/code/'.$code->id) }}">{{ $code->code }}</a>
                                        </td>
                                        <td>{{ $code->valid_at->format('Y-m-d') }}</td>
                                        <td>{{ $code->valid_at->year }}</td>
                                        <td>{{ $code->user_id ? 'Utilisé' : 'Non utilisé' }}</td>
                                        <td>
                                            @if(isset($code->user))
                                               <a href="{{ secure_url('user/'. $code->user->id) }}">{{ $code->user->name }}</a>
                                            @elseif($code->user_id && !isset($code->user))
                                                <p>Utilisateur supprimé, id: {{ $code->user_id }}</p>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a class="btn btn-sm btn-primary btn-block mr-1" href="{{ secure_url('backend/code/'.$code->id) }}"><i class="fas fa-edit"></i></a>
                                        </td>
                                        <td class="text-right">
                                            @if($code->can_be_deleted)
                                                <form action="{{ url('backend/code/'.$code->id) }}" method="POST" class="d-flex flex-row justify-content-between align-items-center">
                                                    <input type="hidden" name="_method" value="DELETE">@csrf
                                                    <button data-what="supprimer" data-action="{{ $code->code }}" class="btn btn-danger btn-sm btn-block deleteAction ml-1">x</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif

                        @if($codes instanceof \Illuminate\Pagination\LengthAwarePaginator )
                            {!! $codes->links() !!}
                        @endif

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </div>

@stop
