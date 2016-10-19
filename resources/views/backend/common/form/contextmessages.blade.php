@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Запрос обработан с ошибками</strong>
        <br><br>
        <ul>
            @if(gettype($errors) == 'object')
                @foreach($errors->all() as $error)
                    <li>{{e($error)}}</li>
                @endforeach
            @else
                @foreach($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endif
        </ul>
    </div>
@endif

@if (session('success') && count(session('success')) > 0)
    <div class="alert alert-success">
        <strong>Запрос успешно обработан</strong>
        <br><br>
        <ul>
            @foreach(session('success') as $success)
                <li>{{ $success }}</li>
            @endforeach
        </ul>
    </div>
@endif