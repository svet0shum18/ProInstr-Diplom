@extends('layouts.main')

@section('content')

@section('title', $product->name)

  <div class="body_container mt-4">
    <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Каталог</a></li>
        
        @if($product->category)
            <li class="breadcrumb-item">
                <a href="#">
                    {{ $product->category->name }}
                </a>
            </li>
        @endif
        
        @if($product->toolType)
            <li class="breadcrumb-item">
                <a href="#">
                    {{ $product->toolType->name }}
                </a>
            </li>
        @endif
        
        <li class="breadcrumb-item active" aria-current="page">
            {{ $product->name }}
        </li>
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
        <span class="review-count">{{ $product->reviews->count() }} отзывов</span><br>
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
      <div class="col-md-6">
        <div class="spec-item">
        <span class="spec-name">Бренд:</span>
        <span class="spec-value">{{ $product->brand->name}}</span>
        </div>
        <div class="spec-item">
        <span class="spec-name">Мощность:</span>
        <span class="spec-value">{{ $product->power }} кВт</span>
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
      <div class="description-content" style="text-align: justify; margin-right: 60px;">
      {!! $product->full_description !!}
      </div>
    </div>

    <!-- Отзывы -->
  <div class="product-reviews mt-5 ms-5">
    <h3>Отзывы <span class="review-count">({{ $product->reviews->count() }})</span></h3>
    
    @if($product->reviews->isEmpty())
        <div class="no-reviews text-center py-4">
            <p>Пока нет отзывов с фото</p>
            <p>Будьте первыми и помогите другим с выбором</p>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                Написать отзыв
            </button>
        </div>
    @else
        <div class="reviews-container mb-4">
            <!-- Фильтры -->
            <!-- Список отзывов -->
            @foreach($product->reviews as $review)
                <div class="review-item mb-4 p-3 border rounded mt-4 me-5">
                    <div class="d-flex justify-content-between">
                        <div class="review-author fw-bold">
                            {{ $review->user->name }}
                        </div>
                        <div class="review-rating text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </div>
                    </div>
                    <div class="review-date small text-muted mb-2">
                        {{ $review->created_at->format('d.m.Y') }}
                    </div>
                    <div class="review-text mb-3">
                        {{ $review->comment }}
                    </div>
                    
                    @if($review->photos)
                        <div class="review-photos">
                            @foreach($review->photos as $photo)
                                <a href="{{ asset('storage/reviews/'.$photo) }}" data-lightbox="review-{{ $review->id }}">
                                    <img src="{{ asset('storage/reviews/thumbs/'.$photo) }}" 
                                         class="img-thumbnail m-1" 
                                         style="max-height: 80px">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            
            <!-- Кнопка добавления отзыва -->
            <div class="text-center mt-4">
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reviewModal">
                    Оставить отзыв
                </button>
            </div>
        </div>
    @endif
</div>

<!-- Модальное окно для отзыва -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Оставить отзыв</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Ваша оценка</label>
                        <div class="rating-stars">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                                <label for="star{{ $i }}">★</label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Комментарий</label>
                        <textarea name="comment" class="form-control rounded-4" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Фото (макс. 3)</label>
                        <input type="file" name="photos[]" class="form-control" multiple accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-warning">Отправить отзыв</button>
                </div>
            </form>
        </div>
    </div>
</div>

  @endsection