@extends('layouts.admin')

@section('title', 'Модерация отзывов')

@section('content')

<div class="body-container mt-4">

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Профиль</a></li>
      <li class="breadcrumb-item active" aria-current="page">Модерация отзывов</li>
    </ol>
    </nav>

    <h1 class="mb-4">Модерация отзывов</h1>

    <div class="row">

      <div class="col-md-3">
      <!-- Левое меню -->
      @include('partials.admin_menu')

    </div>

    <div class="col-md-9">


    <div class="card-body">
      @if($noReviews)
    <div class="text-dark h5 text-center mt-5">
        Отзывов на модерацию пока нет.
    </div>
@else
        @foreach($reviews as $review)
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6>Товар: {{ $review->product->name }}</h6>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </div>
                        <p>{{ $review->comment }}</p>
                        <small class="text-muted">
                            Автор: {{ $review->user->name }}, 
                            {{ $review->created_at->format('d.m.Y H:i') }}
                        </small>
                    </div>
                    <div class="col-md-4 d-flex justify-content-end gap-2 review-actions">
                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i> Одобрить
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
        
        {{ $reviews->links() }}
    </div>
    </div>
    </div>
</div>

@endsection