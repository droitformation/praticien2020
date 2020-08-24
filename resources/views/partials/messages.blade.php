@if(session()->has('status'))
    <div class="alert alert-{{ session()->get('status') }}" role="alert">
        <p class="mb-0">{!! session()->get('message') !!}</p>
    </div>
@endif
