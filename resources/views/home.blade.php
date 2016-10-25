@extends('layouts.backend')

@section('title', 'Административная панель')

@include('backend.homemenu')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Главная панель</div>

                <div class="panel-body">
                    Вы находитесь в административной панели!<br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
