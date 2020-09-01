@extends('decisions.index')
@section('options')
    <a class="btn btn-sm btn-print" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> &nbsp;Retour</a>
@endsection
@section('section')
    @parent

    @inject('clean', '\App\Praticien\Bger\Utility\Clean')

    <div class="decision-details">
        <div class="dates">
            <div><strong class="block">Publication: </strong>{{ $decision->publication_at->format('d/m/Y') }}</div>
            <div><strong class="block">Décision: </strong>{{ $decision->decision_at->format('d/m/Y') }}</div>
            {!! $decision->publish ? '<div><strong class="block">Proposé pour la publication</strong></div>' : '' !!}
        </div>
        <div><button class="btn btn-sm btn-print" type="button" onclick="printJS('print_main', 'html')">Imprimer</button></div>
    </div>

    <div id="print_main" class="decision_main">
        {!! $decision->texte !!}
    </div>

@endsection
