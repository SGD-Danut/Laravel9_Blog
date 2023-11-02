@if (count($errors) > 0)
    <ul class="list-group">
    @foreach($errors->all() as $error)
        <li class="list-group-item list-group-item-danger">{{ $error }}</li>
    @endforeach
    </ul>
@endif

@if (Session::has('success'))
    <div class="alert alert-success" role="alert">
        {!! Session::get('success') !!}
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {!! Session::get('error') !!}
    </div>
@endif