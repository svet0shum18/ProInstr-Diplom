@extends('layouts.main')

@section('title', 'Мои заказы')

@section('content')
  <div class="body-container mt-4">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Профиль</a></li>
      <li class="breadcrumb-item active" aria-current="page">Мои заказы</li>
    </ol>
    </nav>
    <h1 class="mb-4">Мои заказы</h1>

    <div class="row">

    <div class="col-md-3">
      <!-- Левое меню -->
      @include('partials.profile_menu')
      <!-- Фильтр заказов -->
      @include('partials.filter_order')
    </div>
    <!-- Правая часть с заказами -->
    <div class="col-md-9">
      <div id="loadingIndicator" class="text-center py-3" style="display: none;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Загрузка...</span>
      </div>
      </div>

      @if($orders->isEmpty())
      <div class="alert alert-info">
      У вас пока нет заказов. <a href="#" class="alert-link">Начать покупки</a>
      </div>
    @else
      @foreach($orders as $order)
      <div class="mb-4 order-card" data-order-id="{{ $order->id }}"">
      <div class="card profile-card h-100">
      <div class="card-header d-flex justify-content-between align-items-center bg-transparent">
        <h5 class="mb-0 text-dark">Заказ #{{ $order->id }}</h5>
        <span class="badge 
      @if($order->status == 'new') bg-primary
      @elseif($order->status == 'processing') bg-warning text-dark
      @elseif($order->status == 'completed') bg-success
      @elseif($order->status == 'cancelled') bg-danger
      @endif">
        {{ $order->status_text }}
        </span>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
        <div>
        <small class="text-muted">Дата заказа</small>
        <p class="mb-0 h5">{{ $order->created_at->format('d.m.Y H:i') }}</p>
        </div>
        <div class="text-end">
        <small class="text-muted">Сумма</small>
        <p class="mb-0 fw-bold h5">{{ number_format($order->total, 0, '', ' ') }} ₽</p>
        </div>
        </div>

        <h6 class="mt-3 mb-2">Состав заказа:</h6>
        <div class="order-items">
        @foreach($order->items->take(3) as $item)
      <div class="d-flex align-items-center mb-2">
        <img src="{{ asset('assets/img/product/' . $item->product->image) }}" alt="{{ $item->product->name }}"
        class="img-thumbnail me-2" width="90">
        <div class="flex-grow-1">
        <p class="mb-0">{{ $item->product->name }}</p>
        <p class="mb-0 text-muted">{{ $item->quantity }} × {{ number_format($item->price, 0, '', ' ') }}
        ₽
        </p>
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
      <div class="card-footer bg-transparent">
        <div class="d-flex justify-content-between align-items-center">
        <!-- Кнопка "Подробнее" -->
        <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
        Подробнее о заказе
        </a>

        @if($order->status == 'new')
      <!-- Форма отмены заказа -->
      <form action="{{ route('order.cancel', $order->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger cancel-order-btn">
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
    </div>
    @if($orders->hasPages())
    <div class="mt-4 pagination-container">
    {{ $orders->appends(request()->query())->links() }}
    </div>
    @endif
  </div>
  </div>

@endsection