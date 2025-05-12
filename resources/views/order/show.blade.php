@extends('layouts.main')

@section('title', 'Детали заказа #' . $order->id)

@section('content')
  <div class="body-container mt-4">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Профиль</a></li>
      <li class="breadcrumb-item"><a href="{{ route('order.orderuser') }}">Мои заказы</a></li>
      <li class="breadcrumb-item active">Заказ #{{ $order->id }}</li>
    </ol>
    </nav>

    <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center bg-transparent">
      <h4>Заказ #{{ $order->id }}</h4>
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
      <div class="row mb-4">
      <div class="col-md-6">
        <h3 class="text-dark">Информация о заказе</h3>
        <p class="h5 mt-3"><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
        <p class="h5 mt-3"><strong>Сумма:</strong> {{ number_format($order->total, 0, '', ' ') }} ₽</p>
        
      </div>
      </div>

      <h5 class="mb-3 text-dark">Состав заказа:</h5>
      <div class="table-responsive">
      <table class="table">
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
        <img src="{{ asset('assets/img/products/' . $item->product->image) }}" width="60" class="me-3">
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
      </div>
    </div>
    </div>
  </div>
@endsection