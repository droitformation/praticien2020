@extends('layouts.app')
@section('content')

    <div class="container-fluid mt-4">

        <div class="row">
            <div class="col-lg-6">
                <h3 class="mb-3 mt-0">Nouvel utilisateur</h3>

                <form method="POST" action="{{ secure_url('backend/user') }}" class="py-2">@csrf

                    <div class="card">
                        <div class="card-body">

                            <div class="mt-3 pt-2 border-top">
                                <h3 class="mb-3 font-size-17">Données</h3>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <select class="form-control">
                                        <option value="3">Abonné | Accès aux contenus du site</option>
                                        <option value="2">Contributeur | Introduction des fiches </option>
                                        <option value="1">Administrateur</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12"><input type="email" name="email" class="form-control" value="" required placeholder="Email"></div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <input type="text" name="first_name" class="form-control" value="" required placeholder="Prénom">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="last_name" class="form-control" value="" required placeholder="Nom">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <input type="text" name="adresse" class="form-control" value="" placeholder="Adresse">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <input type="text" name="npa" class="form-control" value="" placeholder="NPA">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="ville" class="form-control" value="{{ $user->ville }}" placeholder="Ville">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12"><input type="text" name="active_until" class="form-control datePicker" value=""></div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <input type="text" name="password" class="form-control" placeholder="Mot de passe">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row align-items-end">
                                <div class="col-lg-12 text-right">
                                    <button class="btn btn-primary" type="submit">Enregistrer</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>

            <div class="col-lg-3">
                <h3 class="mb-3 mt-0">Codes</h3>

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
            </div>
        </div>

    </div>

@stop
