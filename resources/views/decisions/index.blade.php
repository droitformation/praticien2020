@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                // 'publication_at', 'decision_at', 'categorie_id', 'remarque', 'link', 'numero', 'texte', 'langue', 'publish', 'updated'
                @if(!$decisions->isEmpty())
                    <table>
                        <tr>
                            <th>Numéro</th>
                            <th>Catégorie</th>
                        </tr>
                        @foreach($decisions as $decision)
                            <tr>
                                <td>{{ $decision->numero }}</td>
                                <td>{{ $decision->categorie->name }}</td>
                            </tr>
                        @endforeach
                    </table>

                @endif

            </div>
        </div>
    </div>
@endsection
