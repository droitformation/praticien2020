@extends('layouts.master')
@section('content')

    <section class="event-one">
        <div class="container">
            <div class="block-title-two text-center">
                <h3>Décisions</h3>
            </div><!-- /.block-title-two -->
            <div class="row">
                <div class="col-lg-12">

                    {{-- 'publication_at', 'decision_at', 'categorie_id', 'remarque', 'link', 'numero', 'texte', 'langue', 'publish', 'updated'--}}
                    @if(!$decisions->isEmpty())
                        <table id="decisions">
                            <thead>
                            <tr>
                                <th>Publication</th>
                                <th>Décision</th>
                                <th>Référence</th>
                                <th>Catégorie</th>
                                <th>Lang.</th>
                                <th>A publication</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($decisions as $decision)
                                <tr>
                                    <td>{{ $decision->publication_at->format('d/m/Y') }}</td>
                                    <td>{{ $decision->decision_at->format('d/m/Y') }}</td>
                                    <td>{{ $decision->numero }}</td>
                                    <td>
                                        {{ $decision->categorie->name }}<br>
                                        {{ $decision->remarque }}
                                    </td>
                                    <td>{{ $decision->lang }}</td>
                                    <td>{!! $decision->publish ? '<i class="fas fa-check"></i>' : '' !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @endif

                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>


@endsection
