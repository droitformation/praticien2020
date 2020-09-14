@if( (isset($errors) && count($errors) > 0) )
    <div class="alert alert-dismissable alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        @foreach($errors->all() as $message)
            <p class="mb-0">{!! $message !!}</p>
        @endforeach
    </div>
@endif
