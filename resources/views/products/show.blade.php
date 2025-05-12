@extends('layouts.main')

@section('content')

@section('title', $product->name)

  <div class="body_container mt-4">
    <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Каталог</a></li>
      <li class="breadcrumb-item"><a href="#">Бензо-инструменты</a></li>
      <li class="breadcrumb-item"><a href="{{ route('products.chainsaw') }}">Бензопилы</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
    </ol>
    </nav>
    <div class="profile-card">
    <div class="row">
      <!-- Основная информация о товаре -->
      <div class="col-md-6">
      <div class="product-gallery">
        <img src="{{ asset('assets/img/products/' . $product->image) }}" class="img-fluid main-image"
        alt="{{ $product->name }}" style="width: 500px; padding: 20px;">

      </div>
      </div>

      <div class="col-md-6">
      <h1 class="product-title mt-4">{{ $product->name }}</h1>

      <!-- Рейтинг и отзывы -->
      <div class="rating mb-3">
        <span class="stars">★★★★★</span>
        <span class="review-count">51 отзыв</span><br>
        <span class="reliability-badge">Хорошая надежность</span>
      </div>

      <!-- Цена и условия покупки -->
      <div class="price-section mb-4">
        <div class="price-sec ms-2">
        <div class="current-price">{{ number_format($product->price, 0, '', ' ') }} ₽</div>
        <div class="installment">от 950 ₽/мес.</div>
        </div>

        <div class="product-actions me-2">
        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn-add-cart-full">
          Купить
        </button>
        </form>

        <form action="{{ route('favorite.add', $product->id) }}" method="POST" class="d-inline ms-2">
        @csrf
        <button type="submit" class="btn-add-fav-full">
          <i class="far fa-heart fa-xl"></i>
        </button>
        </form>
      </div>

      </div>

      <!-- Наличие -->
      <div class="availability mb-4">
        @if($product->quantity > 0)
      <i class="fas fa-check-circle text-success"></i>
      <span class="text-success">В наличии</span>
      <small class="text-muted d-block mt-1">Количество: {{ $product->quantity }} шт.</small>
      @else
      <i class="fas fa-times-circle text-danger"></i>
      <span class="text-danger">Нет в наличии</span>
      @endif
      </div>

      <!-- Кнопки действий -->


      <!-- Доставка -->
      <div class="delivery-info">
        <div><i class="fas fa-truck mb-3"></i> Доставка от 290р.</div>
        <div><i class="fas fa-store"></i>Самовывоз: г. Владивосток, п. Трудовое,<br>
                                                ул.Лермнотова 70, стр 5, 2 этаж,<br>
                                                ТЦ Лермонтов</div>
      </div>
      </div>
    </div>

    <!-- Характеристики -->
    <div class="product-specs mt-5 ms-5">
      <h3>Характеристики</h3>
      <div class="row mt-3">
      <div class="col-md-6 ">
        <div class="spec-item">
        <span class="spec-name">Бренд:</span>
        <span class="spec-value">{{ $product->brand->name}}</span>
        </div>
        <div class="spec-item">
        <span class="spec-name">Мощность:</span>
        <span class="spec-value">{{ $product->power }} л.с</span>
        </div>
      </div>
      <div class="col-md-6">
        <div class="spec-item">
        <span class="spec-name">Вес: </span>
        <span class="spec-value">{{ $product->weight }} кг.</span>
        </div>
        <div class="spec-item">
        <span class="spec-name">Страна производства: </span>
        <span class="spec-value">{{ $product->brand->country }}</span>
        </div>
      </div>
      </div>
    </div>

    <!-- Описание -->
    <div class="product-description mt-5 ms-5">
      <h3>Описание</h3>
      <div class="description-content">
      {!! $product->full_description !!}
      </div>
    </div>

    <!-- Отзывы -->
    <div class="product-reviews mt-5 ms-5">
      <h3>Отзывы <span class="review-count">(51)</span></h3>
      <div class="no-reviews">
      <p>Пока нет отзывов с фото</p>
      <p>Будьте первыми и помогите другим с выбором</p>
      <button class="btn btn-outline-primary">Написать отзыв</button>
      </div>
    </div>
    </div>

  @endsection