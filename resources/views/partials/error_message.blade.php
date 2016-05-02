@if ($errors->any())
    <div class="alert alert-danger {{ ($errors->any()) ? '' : 'display-hide' }}">
        @foreach ($errors->all() as $error)
            <span>{!! $error !!}</span><br>
        @endforeach
    </div>
@endif

@include('flash::message')