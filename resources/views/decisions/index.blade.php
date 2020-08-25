@extends('layouts.master')
@section('content')

    <section class="event-one">
        <div class="container">
            <div class="block-title-two text-center">
                <h3>Décisions du </h3>
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
                                <th width="60px">A publ.</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    @endif

                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>


@endsection
