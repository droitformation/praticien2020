<div id="deleteModal_{{ $user->id }}" class="p-4" style="display: none; max-width: 600px;">
    <form action="{{ url('backend/user/'.$user->id) }}" method="POST">
        <input type="hidden" name="_method" value="DELETE">@csrf
        <h4 class="py-4">Voulez-vous vraiment supprimer l'utilisateur {{ $user->name }}?</h4>
        <div class="d-flex flex-row justify-content-between">
            <div><button data-fancybox-close="" class="btn btn-light">Annuler</button></div>
            <div><button class="btn btn-danger btn-sm btn-block">Supprimer</button></div>
        </div>
    </form>
</div>
