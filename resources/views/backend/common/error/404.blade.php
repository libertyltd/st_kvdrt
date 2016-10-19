@extends('layouts.backend')

@section('title', 'Запрашиваемая страница не найдена')

@include('homemenu')

@section('content')
    <div class="container-fluid">
        <div class="alert alert-danger">
            <strong>Запрашиваемая страница не найдена!</strong>
        </div>
    </div>
@endsection