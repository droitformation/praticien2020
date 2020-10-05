<div class="row">
    <div class="col-lg-12">

        <h3>Recherche</h3>

        <div class="row">
            <div class="col-lg-4">
                <form action="{{ secure_url('searchTerm') }}" method="POST">@csrf
                    {!! Honeypot::generate('my_name', 'my_time') !!}
                    <div class="input-group mb-3">
                        <input class="form-control" name="term" type="text" placeholder="Termes...">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">Ok</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-8">
                <form action="{{ secure_url('searchLoi') }}" method="POST">@csrf
                    {!! Honeypot::generate('my_name', 'my_time') !!}
                    <div class="input-group mb-3">
                        <input class="form-control" name="params[article]" type="text" placeholder="Article">
                        <input class="form-control" name="params[loi]" type="text" placeholder="Loi">
                        <input class="form-control" name="params[alinea]" type="text" placeholder="Alinéa">
                        <input class="form-control" name="params[chiffre]" type="text" placeholder="Chiffre">
                        <input class="form-control" name="params[lettre]" type="text" placeholder="Lettre">
                        @if(!empty($editions))
                            <select class="custom-select" name="year">
                                <option value="" selected>Édition</option>
                                @foreach($editions as $start => $end)
                                    <option value="{{ $start.'-'.$end }}">{{ $start.'/'.$end }}</option>
                                @endforeach
                            </select>
                        @endif
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">Ok</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
