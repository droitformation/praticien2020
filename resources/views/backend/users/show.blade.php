@extends('layouts.app')
@section('content')

    <div class="container-fluid mt-4">

        <div class="row">
            <div class="col-lg-4">
                <h3 class="mb-3 mt-0">Utilisateur</h3>

                <form method="POST" action="{{ secure_url('backend/user/'.$user->id) }}" class="py-2">@csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{ $user->id }}">

                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mt-3">
                                <h5 class="mt-2 mb-0">{{ $user->name }}</h5>

                                <h6 class="text-muted font-weight-normal mt-2 mb-0">Abonnement actif au</h6>
                                <h6 class="text-{{ $user->valid ? 'success' : 'warning' }} font-weight-normal mt-1 mb-4">{{ isset($user->active_until) ? $user->active_until->format('Y-m-d') : '' }}</h6>
                            </div>

                            <div class="mt-3 pt-2 border-top">
                                <h3 class="mb-3 font-size-17">Données</h3>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <select class="form-control" name="role">
                                        <option {{ $user->roles->contains('id',3) ? 'selected' : '' }} value="3">Abonné | Accès aux contenus du site</option>
                                        <option {{ $user->roles->contains('id',2) ? 'selected' : '' }} value="2">Contributeur | Introduction des fiches </option>
                                        <option {{ $user->roles->contains('id',1) ? 'selected' : '' }} value="1">Administrateur</option>
                                    </select>
                                </div>
                            </div>

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
                                    <input type="text" name="adresse" class="form-control" value="{!! $user->adresse !!}" placeholder="Adresse">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <input type="text" name="npa" class="form-control" value="{{ $user->npa }}" placeholder="NPA">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="ville" class="form-control" value="{{ $user->ville }}" placeholder="Ville">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12"><input type="text" name="active_until" class="form-control datePicker" value="{{ $user->active_until }}"></div>
                            </div>

                            <a href="#" class="d-block text-muted" data-toggle="collapse" data-target="#password_{{ $user->id }}"><i class="fas fa-lock"></i> &nbsp;Modifier le mot de passe</a>

                            <div class="row mb-4 collapse mt-4" id="password_{{ $user->id }}">
                                <div class="col-lg-12">
                                    <input type="text" name="password" class="form-control" placeholder="Mot de passe">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row align-items-end">
                                <div class="col-lg-6">
                                    <a data-fancybox="" data-src="#deleteModal_{{ $user->id }}" data-modal="true" href="javascript:;" class="text-danger"><i class="fas fa-exclamation-circle"></i> &nbsp;Supprimer</a>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button class="btn btn-primary" type="submit">Enregistrer</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
            <div class="col-lg-5">

                <h3 class="mb-2 mt-0">Abonnements</h3>

                @if(!$user->abonnements->isEmpty())
                    <div class="d-flex flex-col justify-content-between flex-wrap" >
                        @foreach($user->abonnements as $abo)
                            <div class="card card-categorie bg-white border">
                                <div class="card-body">
                                    <p class="m-0">
                                        <strong>Catégorie:</strong> <span class="{{ $abo['published'] ? 'text-danger' : '' }}">{{ $abo['title'] }}{{ $abo['published'] ? '*' : '' }}</span>
                                    </p>
                                    {!! !$abo['keywords']->flatten()->isEmpty() ? '<p class="m-0 font-italic">'.$abo['keywords']->flatten()->implode(', ').'</p>' : '' !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
            <div class="col-lg-3">
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
