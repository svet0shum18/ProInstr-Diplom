@extends('layouts.main')

@section('title', 'Детали заказа #' . $order->id)

@section('content')
  <div class="container-fluid body-container mt-3 mt-md-4">
    <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Профиль</a></li>
        <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Мои заказы</a></li>
        <li class="breadcrumb-item active">Заказ #{{ $order->id }}</li>
      </ol>
    </nav>

    <!-- Карточка заказа -->
    <div class="card">
      <!-- Заголовок карточки -->
      <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center bg-transparent p-3">
        <h4 class="mb-2 mb-md-0 text-start text-md-start">Заказ #{{ $order->id }}</h4>
        <span class="badge mt-2 mt-md-0
          @if($order->status == 'new') bg-primary
          @elseif($order->status == 'processing') bg-warning text-dark
          @elseif($order->status == 'completed') bg-success
          @elseif($order->status == 'cancelled') bg-danger
          @endif">
          {{ $order->status_text }}
        </span>
      </div>

      <!-- Тело карточки -->
      <div class="card-body p-3">
        <!-- Информация о заказе -->
        <div class="row mb-3 mb-md-4">
          <div class="col-12 col-md-6">
            <h3 class="text-dark mb-3">Информация о заказе</h3>
            <div class="d-flex flex-column gap-2">
              <p class="h5 mb-0"><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
              <p class="h5 mb-0"><strong>Сумма:</strong> {{ number_format($order->total, 0, '', ' ') }} ₽</p>
            </div>
          </div>
        </div>

        <!-- Состав заказа -->
        <h5 class="mb-3 text-dark">Состав заказа:</h5>
        <div class="table-responsive">
          <!-- Для десктопов - таблица -->
          <table class="table d-none d-md-table">
            <thead>
              <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order->items as $item)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{ asset('assets/img/products/' . $item->product->image) }}" 
                           width="60" 
                           class="me-3"
                           style="object-fit: cover;">
                      {{ $item->product->name }}
                    </div>
                  </td>
                  <td>{{ number_format($item->price, 0, '', ' ') }} ₽</td>
                  <td>{{ $item->quantity }}</td>
                  <td>{{ number_format($item->price * $item->quantity, 0, '', ' ') }} ₽</td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <!-- Для мобильных - карточки -->
          <div class="d-md-none">
            @foreach($order->items as $item)
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <!-- Изображение товара -->
                    <div class="col-4">
                      <img src="{{ asset('assets/img/products/' . $item->product->image) }}" 
                           class="img-fluid rounded"
                           style="object-fit: cover;">
                    </div>
                    <!-- Информация о товаре -->
                    <div class="col-8">
                      <h6 class="card-title">{{ $item->product->name }}</h6>
                      <div class="d-flex justify-content-between">
                        <span class="text-muted">Цена:</span>
                        <span>{{ number_format($item->price, 0, '', ' ') }} ₽</span>
                      </div>
                      <div class="d-flex justify-content-between">
                        <span class="text-muted">Кол-во:</span>
                        <span>{{ $item->quantity }}</span>
                      </div>
                      <div class="d-flex justify-content-between fw-bold mt-2">
                        <span>Сумма:</span>
                        <span>{{ number_format($item->price * $item->quantity, 0, '', ' ') }} ₽</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection