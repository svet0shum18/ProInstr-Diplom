@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Добро пожаловать, {{ Auth::user()->name }}!</h1>
        <p>Здесь будет информация о вашем профиле.</p>
    </div>
@endsection