@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li style="line-height: 20px">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif