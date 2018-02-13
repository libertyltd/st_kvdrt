@extends('layouts.app')
@section('content')
    <header>
        <div class="logo">
            <a href="/">
                <img src="/images/logo.png" alt="">
            </a>
        </div>
        <ul class="header_menu">
        </ul>
    </header>
    <div class="container">
        <h1 class="lg-head" style="font-weight: normal">404 Страница не найдена</h1>
        <div style="margin-bottom: 30px;">
            <a href="/" style="text-decoration: underline;">На главную</a>
        </div>
    </div>
    <footer>
        <div class="logo">
            <a href="/">
                <img src="/images/white-logo.png" alt="">
                <span>copyright {{date('Y')}}</span>
            </a>
        </div>
    </footer>
@endsection