@extends('layouts.master')
@section('content')

    <section class="event-one">
        <div class="container">
            <div class="block-title-two text-center">
                <h3>Décisions du </h3>
            </div><!-- /.block-title-two -->

            <form class="d-flex flex-row justify-content-between mb-4" method="post" action="{{ secure_url('decisions') }}">@csrf
                <div class="form-group "><input placeholder="Début" class="form-control datepicker" name="period[]"></div>
                <div class="form-group "><input placeholder="Fin" class="form-control datepicker" name="period[]"></div>
                <div class="form-group "><input placeholder="Termes" class="form-control" name="terms"></div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" value="1" name="published" id="publication">
                    <label class="form-check-label" for="publication">a publication</label>
                </div>
                <div><button class="btn btn-sm btn-success" type="submit">Ok</button></div>
            </form>

            <div class="row">
                <div class="col-lg-9">

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

                </div>
                <div class="col-lg-3">

                    @if(!$parents->isEmpty())
                        <div class="accordion sidebar-list" id="SidebarList">
                            @foreach($parents as $parent)
                                <div>
                                    <a class="parent-link" data-toggle="collapse" data-target="#cat_{{ $parent->id }}">
                                        <span>{{ $parent->nom }}</span><i class="fas fa-caret-right"></i>&nbsp;
                                    </a>
                                    <div id="cat_{{ $parent->id }}" class="collapse" aria-labelledby="cat_{{ $parent->id }}" data-parent="#SidebarList">

                                        @if(!$parent->categories->isEmpty())
                                            @foreach($parent->categories as $categorie)
                                               <a class="child-link" href="{{ secure_url('categorie/'.$categorie->id) }}">{{ $categorie->name }}</a>
                                            @endforeach
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>


@endsection
