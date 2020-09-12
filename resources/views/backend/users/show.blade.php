@extends('layouts.app')
@section('content')

    <div class="container-fluid mt-4">

        <div class="row">
            <div class="col-lg-4">
                <h3 class="mb-3 mt-0">Utilisateur</h3>
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mt-3">
                            <h5 class="mt-2 mb-0">{{ $user->name }}</h5>
                            <h6 class="text-muted font-weight-normal mt-2 mb-0">Abonnement actif au</h6>
                            <h6 class="text-{{ $user->valid ? 'success' : 'warning' }} font-weight-normal mt-1 mb-4">{{ isset($user->active_until) ? $user->active_until->format('Y-m-d') : '' }}</h6>
                        </div>

                        <div class="mt-3 pt-2 border-top">
                            <h4 class="mb-3 font-size-15">Données</h4>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0 text-muted">
                                    <tbody>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Adresse</th>
                                        <td>{!! $user->adresse !!}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">NPA/Ville</th>
                                        <td>{{ $user->npa }} {{ $user->ville }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->

            </div>
            <div class="col-lg-4">
                <h3 class="mb-3 mt-0">Editer</h3>

                <div class="card">
                    <div class="card-body">

                        <form method="POST" action="{{ secure_url('backend/user/'.$user->id) }}" class="py-2">@csrf
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $user->id }}">

                            <div class="row mb-4">
                                <div class="col-lg-12"><input type="email" name="email" class="form-control" value="{{ $user->email }}" required placeholder="Email"></div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" required placeholder="Prénom">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" required placeholder="Nom">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <input type="text" name="adresse" class="form-control" value="{{ $user->adresse }}" required placeholder="Adresse">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <input type="text" name="npa" class="form-control" value="{{ $user->npa }}" placeholder="NPA">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="ville" class="form-control" value="{{ $user->ville }}" required placeholder="Ville">
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-lg-6">
                                    <a data-fancybox="" data-src="#deleteModal_{{ $user->id }}" data-modal="true" href="javascript:;" class="text-danger"><i class="fas fa-exclamation-circle"></i> &nbsp;Supprimer</a>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button class="btn btn-primary" type="submit">Enregistrer</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h3 class="mb-3 mt-0">Codes</h3>
                @if(!$user->codes->isEmpty())
                    @foreach($user->codes as $code)
                       <div class="card {{ !$code->valid_at->isFuture() ? 'bg-light' : '' }}">
                           <div class="card-body p-0">
                               <div class="media p-3">
                                   <div class="media-body">
                                       <span class="text-muted text-uppercase font-size-12 font-weight-bold">
                                           {{ $code->valid_at->format('Y-m-d') }}
                                       </span>
                                       <h2 class="mb-0">{{ $code->code }}</h2>
                                   </div>
                                   <div class="align-self-center">
                                       <i class="fas {{ $code->valid_at->isFuture() ? 'fa-check text-success' : 'fa-times text-danger' }}"></i>
                                   </div>
                               </div>
                           </div>
                       </div>
                    @endforeach
                @endif

                <a data-fancybox="" data-src="#trueModal" data-modal="true" href="javascript:;" class="btn btn-primary"><i class="fas fa-plus"></i> &nbsp;Appliquer un code</a>
                <div id="trueModal" class="p-4" style="display: none; max-width: 600px;">
                    <form action="{{ secure_url('backend/users/code') }}" method="POST">@csrf
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input id="code" name="code" class="form-control" type="text" placeholder="">
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <input name="id" type="hidden" value="{{ $user->id }}">
                            <div><button data-fancybox-close="" class="btn btn-light">Annuler</button></div>
                            <div><button type="submit" class="btn btn-primary">Appliquer</button></div>
                        </div>
                    </form>
                </div>

               @include('backend.users.partials.delete', ['user' => $user])

            </div>
        </div>

    </div>

@stop
