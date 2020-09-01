@extends('decisions.index')
@section('options')

    <form method="post" action="{{ secure_url('categorie/'.$categorie->id) }}">@csrf
        <div class="input-date"><input placeholder="Début" class="form-control datepicker" name="period[]" value="{{ converForDatePicker($params['period'])[0] }}"></div>
        <div class="input-date"><input placeholder="Fin" class="form-control datepicker" name="period[]" value="{{ converForDatePicker($params['period'])[1] }}"></div>
        <div class="input-terms"><input placeholder="Recherche..." class="form-control" name="terms" value="{{ $params['terms'] ?? '' }}"></div>
        <div class="form-check input-publication">
            <input type="checkbox" class="form-check-input" value="1" {{ isset($params['published']) ? 'checked' : '' }} name="published" id="publication">
            <label class="form-check-label" for="publication">a publication</label>
        </div>
        <div><button class="btn btn-sm btn-search" type="submit">Envoyer</button></div>
        <div class="option-btn"><a class="text-black-50" href="{{ secure_url('categorie/'.$categorie->id.'?clear') }}">Retirer les filtres</a></div>
    </form>

@endsection
@section('section')
    @parent

    <h3>{{ $categorie->name }}</h3>
    <h4 class="decisions-period">Du {{ frontendDates($params['period']) }}</h4>

    @if(!$decisions->isEmpty())
        <table id="decisions" class="table table-striped table-bordered dataTable">
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
            <tbody>
            @foreach($decisions as $decision)
                <tr>
                    <td>{{ $decision->publication_at->format('d/m/Y') }}</td>
                    <td>{{ $decision->decision_at->format('d/m/Y') }}</td>
                    <td><a href="{{ secure_url('decision/'.$decision->id.'/'.$decision->publication_at->format('Y')) }}">{{ $decision->numero }}</a></td>
                    <td>{{ $decision->categorie->name ?? '' }}</td>
                    <td>{{ $decision->lang }}</td>
                    <td>{!! $decision->publish ? '<i class="fas fa-check"></i>' : '' !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    {{--  'publication_at', 'decision_at', 'categorie_id', 'remarque', 'link', 'numero', 'texte', 'langue', 'publish', 'updated' --}}
@endsection
