@extends('layouts.main')

@section('title', 'Восстановление пароля')

@section('content')
  <div class="auth-wrapper">

    <h2 class="zag-section mt-4" style="text-align: center;">Восстановить пароль</h2>
    <p>Введите адрес электронной почты, для получения ссылки на восстановление пароля!</p>

    <div class="form-auth mt-2">

    <form action="{{ route('password.email') }}" method="POST">
      @csrf

      <div class="mb-3">
      <label for="email" class="form-label ">Email</label>
      <input name="email" type="email" class="form-control @error('email') is-invalid
    @enderror" id="email" placeholder="Email" value="{{ old('email') }}">
      <div class="invalid-feedback">
        Пожалуйста, введите email.
      </div>
      </div>

      <div class="btn-position">
      <button type="submit" class="btn-auth">Отправить</button>
      </div>
    </form>
    </div>
  </div>

@endsection