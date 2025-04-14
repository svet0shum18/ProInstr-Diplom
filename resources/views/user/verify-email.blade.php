@extends('layouts.main')

@section('title', 'Подтверждение почты')

@section('content')

<div class="alert alert-info" role="alert">
  На вашу почту было отправлено письмо для подтверждения регистрации!
</div>
<div>
  Не пришла ссылка?
  <form action="{{ route('verification.send') }}" method="post">
    @csrf
    <button type="submit" class="btn btn-link">Отправить ссылку</button>
  </form>
</div>

@endsection