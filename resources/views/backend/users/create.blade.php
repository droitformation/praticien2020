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
                                    <input type="text" name="ville" class="form-control" value="" placeholder="Ville">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <label>Date de validité du compte</label>
                                    <input type="text" name="active_until" class="form-control datePicker" value="Date de validité du compte">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <input type="password" name="password" class="form-control" placeholder="Mot de passe">
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

        </div>

    </div>

@stop
