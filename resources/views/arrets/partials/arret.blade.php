<div class="blog-one__content">
    <ul class="blog-one__meta list-unstyled">
        @if(!$arret->subthemes->isEmpty())
            @foreach($arret->subthemes as $subtheme)
                <li><a href="{{ secure_url('theme/'.$subtheme->id) }}">{{ $subtheme->name }}</a></li>
            @endforeach
        @endif
    </ul>
    <h3>{!! $arret->title_link ?? '<a href="#">'.$arret->title.'</a>' !!}</h3>
    <p>{!! $arret->content !!}</p>
    {!! $arret->getMeta('auteur') ? '<p class="blog-one__link">'.$arret->getMeta('auteur').'</p>' : '' !!}
</div>
