@extends('layouts.main')

@section('title', 'Вход')

@section('content')
  <div class="auth-wrapper">

    <h2 class="zag-section mt-4" style="text-align: center;">Вход в аккаунт</h2>

    <div class="form-auth mt-2">

    <form action="{{ route('login.auth') }}" method="POST">
      @csrf

      <div class="mb-3">
      <label for="email" class="form-label ">Email</label>
      <input name="email" type="email" class="form-control @error('email') is-invalid
    @enderror" id="email" placeholder="Email">
      <div class="invalid-feedback">
        Пожалуйста, введите email.
      </div>
      </div>

      <div class="mb-3">
      <label for="password" class="form-label">Пароль</label>
      <div class="password-wrapper">
        <input name="password" type="password" class="form-control @error('password') is-invalid
      @enderror " id="password" placeholder="Введите пароль">
        <div class="invalid-feedback">
        Пожалуйста, введите пароль.
        </div>
        <span class="toggle-password" onclick="togglePassword('password', this)">
        <i class="fa-solid fa-eye"></i>
        </span>
      </div>
      </div>

      <div class="form-check">
      <input name="remember" class="form-check-input" type="checkbox" id="remember">
      <label class="form-check-label" for="remember">
        Запомнить меня?
      </label>
      </div>
      
      <div class="btn-position">
      <button type="submit" class="btn-auth">Войти</button>
      <p class="mt-3 text-center">
        Забыли пароль?
        <a href="{{ route('password.request') }}" class="text-primary text-decoration-underline">Восстановить</a>
      </p>
      </div>
    </form>
    </div>
  </div>

@endsection