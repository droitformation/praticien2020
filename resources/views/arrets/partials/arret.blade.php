<div class="blog-one__content">
    <ul class="blog-one__meta list-unstyled mb-4">
        @if(!$arret->subthemes->isEmpty())
            @foreach($arret->subthemes as $subtheme)
                <li><a href="{{ secure_url('theme/'.$subtheme->id) }}">{{ $subtheme->name }}</a></li>
            @endforeach
        @endif
    </ul>
    <div class="d-flex flex-row justify-content-between align-items-center">
        <h3>{!! $arret->title_link !!}</h3>
        <span class="d-block badge badge-default">{{ $arret->getMeta('year') }}</span>
    </div>
    <p>{!! wpautop($arret->content) !!}</p>

    @if($arret->getMeta('comment'))
        <div class="bg-light p-4 my-4">
            <h5>Commentaire</h5>
            {!! $arret->getMeta('comment') !!}
        </div>
    @endif

    <div class="row">
        <div class="col-md-7">
            {!! $arret->getMeta('auteur') ? '<p class="blog-one__link">'.$arret->getMeta('auteur').'</p>' : '' !!}
        </div>

        <div class="col-md-5 text-right">
            <button class="copy btn btn-sm btn-secondary mt-4" data-clipboard-text="{{ secure_url('arret/'.$arret->id) }}">
                <i class="fas fa-copy"></i> &nbsp;Copier le lien direct vers l'arrêt
            </button>
        </div>
    </div>

</div>
