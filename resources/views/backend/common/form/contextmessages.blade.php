@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Запрос обработан с ошибками</strong>
        <br><br>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
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