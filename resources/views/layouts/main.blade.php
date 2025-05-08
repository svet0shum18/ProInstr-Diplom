<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'ПроИнструмент')</title>
  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Свои стили -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <!-- FONTAWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- GOOGLE_FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
</head>

<body>
  <div class="wrapper">

    <header class="header">
      <div class="header-top py-2 bg-">
        <div class="header_container">
          <div class="row">
            <div class=" col-6 col-sm-4">
              <div class="header-top-phone d-flex align-items-center h-100">
                <i class="fa-solid fa-phone fa-xl"></i>
                <a href="tel:+79243081576" class="ms-2">+7(924)-308-15-76</a>
              </div>
            </div>

            <div class="col-sm-4 d-none d-sm-block ">
              <ul class="social-icons d-flex justify-content-center">
                <li><a href="#"><i class="fa-brands fa-youtube fa-xl"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-whatsapp fa-xl"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-instagram fa-xl"></i></a></li>
              </ul>
            </div>

            <div class="col-6 col-sm-4">
              <div class="d-flex justify-content-end">
                <div class="dropdown">
                  @auth
              <!-- Для авторизованных пользователей -->
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
              aria-expanded="false" id="btn-account">
              {{ auth()->user()->name }}
              </button>
              <ul class="dropdown-menu">
              <li>
                @if(auth()->user()->is_admin)
            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Панель админа</a>
          @else
            <a class="dropdown-item" href="{{ route('dashboard') }}">Личный кабинет</a>
          @endif
              </li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">Выйти</button>
                </form>
              </li>
              </ul>
          @else
            <!-- Для неавторизованных пользователей -->
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false" id="btn-account">
            Аккаунт
            </button>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('login') }}">Вход</a></li>
            <li><a class="dropdown-item" href="{{ route('register') }}">Регистрация</a></li>
            </ul>
          @endauth
                </div>
              </div>
            </div>

          </div>
        </div>
      </div><!-- ./Header-top -->
      <hr style="margin: 0;">

      <div class="header-middle">
        <div class="header_container py-4">
          <div class="row">
            <div class="col-md-3">
              <div class="header-middle_logo d-flex align-items-center h-100">
                <a href="{{ url('/') }}"><img src="/assets/img/chrlogo.svg" alt="logo" id="header-logo"></a>
              </div>
            </div>

            <div class="col-md-6">
              <div class="header-middle_search d-flex align-items-center h-100">
                <form action="" class="w-100">
                  <div class="position-relative">
                    <input type="text" name="search" class="form-control pe-5" placeholder="Поиск ..."
                      aria-label="Поиск ..." aria-describedby="button-addon2">
                    <button
                      class="btn position-absolute end-0 top-50 translate-middle-y me-3 p-0 border-0 bg-transparent"
                      type="submit" id="button-addon2">
                      <i class="fa-solid fa-magnifying-glass" style="color: #6c757d;"></i>
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-md-3">
              <div class="header-middle_nav d-flex align-items-center justify-content-between h-100 w-100">
                <div class="dropdown">
                  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false" id="btn-dropdown">
                    Каталог
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Бензо-инструменты</a></li>
                    <li><a class="dropdown-item" href="#">Климатическое оборудование</a></li>
                    <li><a class="dropdown-item" href="#">Насосное оборудование</a></li>
                    <li><a class="dropdown-item" href="#">Ручные и авто-инструменты</a></li>
                    <li><a class="dropdown-item" href="#">Сварочное оборудование</a></li>
                    <li><a class="dropdown-item" href="#">Электро-инструменты</a></li>
                  </ul>
                </div>
                <a class="nav-link" href="{{ route('cart.index') }}"> Корзина
                  @auth
            <span class="position-absolute translate-middle badge rounded-pill" id="quant">
            {{ auth()->user()->cart_count }}
            <span class="visually-hidden">товаров в корзине</span>
            </span>
          @endauth
                </a>
                <a class="nav-link" href="{{ route('favorite.index') }}">
                  Избранное
                  @auth
            <span class="position-absolute translate-middle badge rounded-pill" id="quant">
            {{ auth()->user()->favorites_count }}  <!-- Подсчитанное количество товаров в избранном -->
            <span class="visually-hidden">товаров в избранном</span>
            </span>
          @endauth
                </a>
                <a class="nav-link" href="#"><i class="fa-solid fa-circle-question fa-lg"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div><!-- ./Header-middle -->

      <div class="header-bottom">
        <div class="marquee py-2">
          <div class="marquee-content">
            <span>Скидки новым покупателям на весь ассотримент 30%</span>
            <span>Огромный ассортимент товаров для вашего строительства!</span>
            <span>Качество, надежность, выгода - ПроИнструмент! Ждем Вас в гости!</span>
            <span>Скидки новым покупателям на весь ассотримент 30%</span>
            <span>Огромный ассортимент товаров для вашего строительства!</span>
            <span>Качество, надежность, выгода - ПроИнструмент! Ждем Вас в гости!</span>
          </div>
        </div>
      </div>
    </header>
    <main class="main">
      <div class="body_container">

        <!-- @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif -->


        <!-- <nav class="mobile-bottom-nav bg-white border-top">
  <div class="d-flex justify-content-around text-center py-2">
    <a href="/home" class="text-decoration-none text-dark">
      <i class="fa-solid fa-house fa-lg"></i><br><small>Главная</small>
    </a>
    <a href="/shops" class="text-decoration-none text-dark">
      <i class="fa-solid fa-store fa-lg"></i><br><small>Магазины</small>
    </a>
    <a href="/catalog" class="text-decoration-none text-dark">
      <i class="fa-solid fa-list fa-lg"></i><br><small>Каталог</small>
    </a>
    <a href="/cart" class="text-decoration-none text-dark position-relative">
      <i class="fa-solid fa-cart-shopping fa-lg"></i><br><small>Корзина</small>
    </a>
    <a href="/profile" class="text-decoration-none text-dark">
      <i class="fa-solid fa-user fa-lg"></i><br><small>Профиль</small>
    </a>
  </div>
</nav> -->

        @yield('content')
      </div>
    </main>
    <footer class="footer bg-dark mt-4">
      <div class="body_container mt-4">
        <div class="row">
          <!-- Map Section -->
          <div class="col-md-5 mb-6">
            <h5>Наш адрес</h5>
            <div class="map-city">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1134.8383541431979!2d132.06098994160817!3d43.297639095441994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5fb3bca1ca8b5f6d%3A0x3fd2b441cff944af!2z0YPQuy4g0JvQtdGA0LzQvtC90YLQvtCy0LAsIDcw0LAsINCi0YDRg9C00L7QstC-0LUsINCf0YDQuNC80L7RgNGB0LrQuNC5INC60YDQsNC5LCDQoNC-0YHRgdC40Y8sIDY5MDkxMg!5e0!3m2!1sru!2sus!4v1737705762439!5m2!1sru!2sus"
                width="550" height="300" style="border-radius: 10px;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>
            <p class="mt-2">г.Владивосток, п.Трудовое, ул.Лермонтова,70
              стр 5,2 этаж, ТЦ Лермонтов</p>
          </div>
          <!-- Contacts Section -->
          <div class="col-md-3 mb-4">
            <h5>Контакты</h5>
            <ul class="list-unstyled">
              <p>+7 (924) 308-1576</p>
              <p>proinstrument@mail.ru</p>
              <p>Пн-Пт: 9:00 - 20:00</p>
            </ul>
          </div>
          <!-- Sitemap Section -->
          <div class="col-md-4">
            <h5>Карта сайта</h5>
            <ul class="list-unstyled">
              <li><a href="#" class="text-white">Главная</a></li>
              <li><a href="#AboutUs" class="text-white">О нас</a></li>
              <li><a href="#" class="text-white">Услуги</a></li>
              <li><a href="#" class="text-white">Контакты</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="text-center mt-3">
        <p class="mb-0">© 2025 ПроИнструмент. Все права защищены.</p>
      </div>
  </div>
  </footer>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script src="{{ asset('assets/js/order.js') }}"></script>
</body>

</html>