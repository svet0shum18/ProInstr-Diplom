@extends('layouts.main')

@section('title', 'Регистрация')

@section('content')
<div class="auth-wrapper">

  <h2 class="zag-section mt-4" style="text-align: center;">Регистрация</h2>

  <div class="form-auth mt-2">

    <form action="{{ route('user.store') }}" method="POST">
      @csrf

      
       <div class="mb-3">
        <label for="name" class="form-label">Имя пользователя</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid
        @enderror" id="name" placeholder="Имя" value="{{ old('name') }}">
        <div class="invalid-feedback">
          Пожалуйста, введите имя пользователя.
        </div>
      </div>

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
      <button type="submit" class="btn-auth">Зарегистрироваться</button>
     
      </div>

    </form>
    </div>
</div>

@endsection