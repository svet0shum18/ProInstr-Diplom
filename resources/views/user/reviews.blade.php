@extends('layouts.main')

@section('title', 'Мои отзывы')

@section('content')
  <div class="container-fluid body_container mt-3 mt-md-4">
    <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Профиль</a></li>
        <li class="breadcrumb-item active" aria-current="page">Мои отзывы</li>
      </ol>
    </nav>
    
    <!-- Заголовок -->
    <h1 class="mb-3 mb-md-4 text-start text-md-start">Мои отзывы</h1>
    
    <div class="row">
      <!-- Левое меню - на мобильных сверху -->
      <div class="col-12 col-md-3 mb-3 mb-md-0">
        @include('partials.profile_menu')
      </div>

      <!-- Основной контент - на мобильных снизу -->
      <div class="col-12 col-md-9">
        @if($reviews->isEmpty())
          <div class="alert alert-info text-center">
            У вас пока нет отзывов
          </div>
        @else
          @foreach($reviews as $review)
            <div class="card mb-3 review-item">
              <div class="card-body p-3">
                <!-- Заголовок отзыва -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-2">
                  <div class="mb-2 mb-md-0">
                    <h5 class="h6 mb-1">
                      <a href="{{ route('products.show', $review->product->id) }}" class="text-decoration-none">
                        {{ $review->product->name }}
                      </a>
                    </h5>
                    <div class="rating">
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

                <!-- Текст отзыва -->
                <div class="review-content mt-2">
                  <p class="mb-2">{{ $review->comment }}</p>
                </div>

                <!-- Кнопки действий -->
                <div class="review-actions mt-3 d-flex flex-wrap gap-2">
                  <!-- Кнопка редактирования -->
                  <button class="btn btn-sm btn-outline-warning edit-review-btn flex-grow-1 flex-md-grow-0" 
                    data-bs-toggle="modal"
                    data-bs-target="#editReviewModal" 
                    data-review-id="{{ $review->id }}" 
                    data-rating="{{ $review->rating }}"
                    data-comment="{{ $review->comment }}" 
                    data-url="{{ route('reviews.update', $review->id) }}">
                    <i class="fas fa-edit d-md-none"></i>
                    <span class="d-none d-md-inline">Редактировать</span>
                  </button>

                  <!-- Форма удаления -->
                  <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="flex-grow-1 flex-md-grow-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Удалить отзыв?')">
                      <i class="fas fa-trash d-md-none"></i>
                      <span class="d-none d-md-inline">Удалить</span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach

          <!-- Пагинация -->
          <div class="mt-3">
            {{ $reviews->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Модальное окно редактирования -->
  <div class="modal fade" id="editReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
              <div class="rating-edit d-flex justify-content-center">
                @for($i = 5; $i >= 1; $i--)
                  <div class="mx-1">
                    <input type="radio" id="editStar{{ $i }}" name="rating" value="{{ $i }}" class="d-none">
                    <label for="editStar{{ $i }}" class="star-radio" style="font-size: 2rem; cursor: pointer;">★</label>
                  </div>
                @endfor
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Комментарий</label>
              <textarea name="comment" id="editReviewComment" class="form-control rounded-4" rows="5" required></textarea>
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

  <style>
    .rating-edit input[type="radio"]:checked + label {
      color: #ffc107;
    }
    .rating-edit label {
      color: #e4e5e9;
      transition: color 0.2s;
    }
    .star-filled {
      color: #ffc107;
    }
    .star-empty {
      color: #e4e5e9;
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Инициализация модального окна редактирования
      const editModal = document.getElementById('editReviewModal');
      if (editModal) {
        editModal.addEventListener('show.bs.modal', function(event) {
          const button = event.relatedTarget;
          const reviewId = button.getAttribute('data-review-id');
          const rating = button.getAttribute('data-rating');
          const comment = button.getAttribute('data-comment');
          const url = button.getAttribute('data-url');

          document.getElementById('editReviewId').value = reviewId;
          document.getElementById('editReviewComment').value = comment;
          document.getElementById('editReviewForm').action = url;

          // Установка рейтинга
          const ratingInput = document.querySelector(`input[name="rating"][value="${rating}"]`);
          if (ratingInput) {
            ratingInput.checked = true;
          }
        });
      }

      // Подсветка звезд при наведении
      const stars = document.querySelectorAll('.rating-edit label');
      stars.forEach(star => {
        star.addEventListener('mouseover', function() {
          const value = this.getAttribute('for').replace('editStar', '');
          highlightStars(value);
        });

        star.addEventListener('mouseout', function() {
          const checked = document.querySelector('.rating-edit input[type="radio"]:checked');
          highlightStars(checked ? checked.value : 0);
        });
      });

      function highlightStars(value) {
        stars.forEach(star => {
          const starValue = star.getAttribute('for').replace('editStar', '');
          star.style.color = starValue <= value ? '#ffc107' : '#e4e5e9';
        });
      }
    });
  </script>
@endsection