@extends('layouts.admin')

@section('content')
    <div class="body_container mt-4">
        <h1>Добро пожаловать, {{ Auth::user()->name }}!</h1>
        <p>Здесь будет информация о вашем профиле.</p>
        <p>ОЧЕНЬТ ЛИЧНАЯ</p>
    </div>
@endsection