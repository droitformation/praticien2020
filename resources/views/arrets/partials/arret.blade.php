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
    {!! $arret->getMeta('auteur') ? '<p class="blog-one__link">'.$arret->getMeta('auteur').'</p>' : '' !!}
</div>
