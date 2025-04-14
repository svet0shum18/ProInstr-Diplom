@extends('layouts.main')

@section('title', 'Восстановление пароля')

@section('content')
<div class="auth-wrapper">

  <h2 class="zag-section mt-4" style="text-align: center;">Восстановление пароля</h2>

  <div class="form-auth mt-2">

    <form action="{{ route('password.update') }}" method="POST">
      @csrf

      <input type="hidden" name="token" value="{{ $token }}">

      <div class="mb-3">
        <label for="email" class="form-label ">Email</label>
        <input name="email" type="email" class="form-control @error('email') is-invalid
        @enderror" id="email" placeholder="Email" value="{{ old('email') }}">
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

      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
          <div class="password-wrapper">
            <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Введите пароль">
            <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">
            <i class="fa-solid fa-eye"></i>
            </span>
          </div>
      </div>

      <div class="btn-position">
      <button type="submit" class="btn-auth">Сбросить пароль</button>
      </div>

    </form>
    </div>
</div>

@endsection