<div class="card position-relative mb-0 border-bottom mb-4">
    <div class="card-body">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <div class="media-body">
                <h5 class="name mb-2">{{ $user->name }} &nbsp;<span class="badge badge-success badge-pill font-size-12">{{ $user->cadence }}</span></h5>
                <h5 class="mt-1 mb-2 email font-size-13">{{ $user->email }}</h5>
                <p class="mb-0">Actif | <span class="text-info">{{ isset($user->active_until) ? $user->active_until->format('Y-m-d') : '' }}</span></p>
            </div>

            <div class="card-text text-center">
                <div class="col">
                    @if(!$user->abonnements->isEmpty())
                        <button class="btn btn-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#collapse_{{ $user->id }}" aria-expanded="false" aria-controls="collapse:{{ $user->id }}"><i class="fas fa-star"></i> &nbsp;Abos</button>
                    @endif
                    <a href="{{ secure_url('backend/user/'.$user->id) }}" class="btn btn-success btn-sm btn-block"><i class="fas fa-edit"></i> &nbsp;Editer</a>
                    <form action="{{ url('backend/user/'.$user->id) }}" method="POST" class="mt-2">
                        <input type="hidden" name="_method" value="DELETE">@csrf
                        <button data-what="supprimer" data-action="{{ $user->name }}" class="btn btn-outline-danger btn-sm btn-block deleteAction"><i class="fas fa-exclamation-circle"></i> &nbsp;Supprimer</button>
                    </form>
                </div>
            </div>

        </div>
        @if(!$user->abonnements->isEmpty())
            <div class="collapse mt-2" id="collapse_{{ $user->id }}">
                <div class="d-flex flex-row justify-content-between flex-wrap" >
                    @foreach($user->abonnements as $abo)
                        <div class="card card-categorie bg-light border">
                            <div class="card-body">
                                <p class="m-0">
                                    <strong>Catégorie:</strong> <span class="{{ $abo['published'] ? 'text-danger' : '' }}">{{ $abo['title'] }}{{ $abo['published'] ? '*' : '' }}</span>
                                </p>
                                {!! !$abo['keywords']->flatten()->isEmpty() ? '<p class="m-0 font-italic">'.$abo['keywords']->flatten()->implode(', ').'</p>' : '' !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
