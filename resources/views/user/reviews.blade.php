@extends('layouts.main')

@section('title', 'Мои отзывы')

@section('content')
  <div class="body_container mt-4">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Профиль</a></li>
      <li class="breadcrumb-item active" aria-current="page">Мои отзывы</li>
    </ol>
    </nav>
    <h1 class="mb-4">Мои отзывы</h1>
    <div class="row">
    <!-- Левое меню -->
    <div class="col-md-3">
      @include('partials.profile_menu')
    </div>

    <!-- Основной контент -->
    <div class="col-md-9">
      @if($reviews->isEmpty())
      <div class="alert alert-info">У вас пока нет отзывов</div>
    @else
      @foreach($reviews as $review)
      <div class="card mb-4 review-item">
      <div class="card-body">
      <div class="d-flex justify-content-between align-items-start">
      <div>
      <h5>
      <a href="{{ route('products.show', $review->product->id) }}">
      {{ $review->product->name }}
      </a>
      </h5>
      <div class="rating mb-2">
      @for($i = 1; $i <= 5; $i++)
      <span class="{{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}">
      {{ $i <= $review->rating ? '★' : '☆' }}
      </span>
      @endfor
      </div>
      </div>
      <small class="text-muted">
      {{ $review->created_at->format('d.m.Y H:i') }}
      </small>
      </div>

      <div class="review-content mt-3">
      <p>{{ $review->comment }}</p>
      </div>

      <div class="review-actions mt-3">
      <!-- Кнопка редактирования -->
      <button class="btn btn-sm btn-outline-warning edit-review-btn" data-bs-toggle="modal"
      data-bs-target="#editReviewModal" data-review-id="{{ $review->id }}" data-rating="{{ $review->rating }}"
      data-comment="{{ $review->comment }}" data-url="{{ route('reviews.update', $review->id) }}">
      Редактировать
      </button>

      <!-- Форма удаления -->
      <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Удалить отзыв?')">
      Удалить
      </button>
      </form>
      </div>
      </div>
      </div>
    @endforeach

      {{ $reviews->links() }}
    @endif
    </div>
    </div>
  </div>

  <!-- Модальное окно редактирования -->
  <div class="modal fade" id="editReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <form id="editReviewForm" method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" name="review_id" id="editReviewId">

      <div class="modal-header">
        <h5 class="modal-title text-dark">Редактировать отзыв</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- Поля формы -->
        <div class="mb-3">
        <label class="form-label">Оценка</label>
        <div class="rating-edit">
          @for($i = 5; $i >= 1; $i--)
        <input type="radio" id="editStar{{ $i }}" name="rating" value="{{ $i }}">
        <label for="editStar{{ $i }}">★</label>
      @endfor
        </div>
        </div>

        <div class="mb-3">
        <label class="form-label">Комментарий</label>
        <textarea name="comment" id="editReviewComment" class="form-control rounded-4" rows="3" required></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-warning">Сохранить</button>
      </div>
      </form>
    </div>
    </div>
  </div>
@endsection