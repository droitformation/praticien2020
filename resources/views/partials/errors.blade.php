@if( (isset($errors) && count($errors) > 0) )
    @foreach($errors->all() as $message)
        <div class="alert alert-danger mb-3" role="alert">
            <p class="mb-0">{!! $message !!}</p>
        </div>
    @endforeach
@endif
