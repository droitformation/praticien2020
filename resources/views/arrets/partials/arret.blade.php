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

    <div class="d-flex flex-row justify-content-between">
        <div>{!! $arret->getMeta('auteur') ? '<p class="blog-one__link">'.$arret->getMeta('auteur').'</p>' : '' !!}</div>

        <div class="text-right">
            <button class="copy btn btn-sm btn-secondary mt-4" data-clipboard-text="{{ secure_url('arret/'.$arret->id) }}">
                <i class="fas fa-copy"></i> &nbsp;Copier le lien direct ver l'arrêt
            </button>
        </div>
    </div>

</div>
