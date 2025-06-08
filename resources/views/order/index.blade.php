@extends('layouts.main')

@section('title', 'Мои заказы')

@section('content')
  <div class="container-fluid body-container mt-3 mt-md-4">
    <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Профиль</a></li>
        <li class="breadcrumb-item active" aria-current="page">Мои заказы</li>
      </ol>
    </nav>
    
    <h1 class="mb-3 mb-md-4 text-start text-md-start">Мои заказы</h1>

    <div class="row">
      <div class="col-12 col-md-3 mb-3 mb-md-0">
        @include('partials.profile_menu')
        @include('partials.filter_order')
      </div>
      
  
      <div class="col-12 col-md-9">
  
        <div id="loadingIndicator" class="text-center py-3" style="display: none;">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Загрузка...</span>
          </div>
        </div>

        @if($orders->isEmpty())
          <div class="alert alert-info text-center">
            У вас пока нет заказов. <a href="#" class="alert-link">Начать покупки</a>
          </div>
        @else
          @foreach($orders as $order)
            <div class="mb-3 mb-md-4 order-card" data-order-id="{{ $order->id }}">
              <div class="card profile-card h-100">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start bg-transparent p-3">
                  <h5 class="mb-2 mb-md-0 text-dark text-start text-md-start">Заказ #{{ $order->id }}</h5>
                  <span class="badge mt-2 mt-md-0
                    @if($order->status == 'new') bg-primary
                    @elseif($order->status == 'processing') bg-warning text-dark
                    @elseif($order->status == 'completed') bg-success
                    @elseif($order->status == 'cancelled') bg-danger
                    @endif">
                    {{ $order->status_text }}
                  </span>
                </div>
                
                <div class="card-body p-3">
                  <!-- Информация о заказе -->
                  <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
                    <div class="mb-2 mb-md-0">
                      <small class="text-muted">Дата заказа</small>
                      <p class="mb-0 h5">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div class="text-md-end">
                      <small class="text-muted">Сумма</small>
                      <p class="mb-0 fw-bold h5">{{ number_format($order->total, 0, '', ' ') }} ₽</p>
                    </div>
                  </div>

                  <!-- Состав заказа -->
                  <h6 class="mt-3 mb-2">Состав заказа:</h6>
                  <div class="order-items">
                    @foreach($order->items->take(3) as $item)
                      <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset('assets/img/products/' . $item->product->image) }}" 
                             alt="{{ $item->product->name }}"
                             class="img-thumbnail me-2" 
                             style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="flex-grow-1">
                          <p class="mb-0 small">{{ $item->product->name }}</p>
                          <p class="mb-0 text-muted small">{{ $item->quantity }} × {{ number_format($item->price, 0, '', ' ') }} ₽</p>
                        </div>
                      </div>
                    @endforeach

                    @if($order->items->count() > 3)
                      <div class="text-center mt-2">
                        <small class="text-muted">+ ещё {{ $order->items->count() - 3 }} товаров</small>
                      </div>
                    @endif
                  </div>
                </div>
                
                <!-- Футер карточки с кнопками -->
                <div class="card-footer bg-transparent p-3">
                  <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                    <!-- Кнопка "Подробнее" -->
                    <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-outline-primary w-md-auto">
                      Подробнее о заказе
                    </a>

                    @if($order->status == 'new')
                      <!-- Форма отмены заказа -->
                      <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="w-md-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger cancel-order-btn w-100">
                          Отменить заказ
                        </button>
                      </form>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
        
        <!-- Пагинация -->
        @if($orders->hasPages())
          <div class="mt-3 mt-md-4 pagination-container">
            {{ $orders->appends(request()->query())->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection