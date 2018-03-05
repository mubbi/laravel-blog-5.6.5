@if (isset($errors) && count($errors) > 0)
<div class="alert alert-danger" role="alert">
    <strong>Oh No!</strong>
    <ul>
    @foreach($errors->all() as $error)
        <li>{!! $error !!}</li>
    @endforeach
    </ul>
</div>
@endif

@if (session()->has('custom_errors'))
<div class="alert alert-success" role="alert">
    <strong>Oh No!</strong> {!! session()->get('custom_errors') !!}
</div>
@endif