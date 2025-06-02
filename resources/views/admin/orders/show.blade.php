@extends('layouts.admin')

@section('title', 'Просмотр заказа #' . $order->id)

@section('content')
  <div class="body-container mt-4">
    <div class="row mb-4">
    <div class="col-12">
      <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i> Назад к списку
      </a>
    </div>
    </div>

    <div class="card shadow">
    <div class="card-header bg-transperent text-dark">
      <h4 class="mb-0">Заказ #{{ $order->id }}</h4>
    </div>
    <div class="card-body">
      <!-- Основная информация -->
      <div class="row mb-4">
      <div class="col-md-6">
        <h5 class="text-dark">Информация о заказе</h5>
       <p><strong>Статус:</strong> 
    <span class="badge rounded-4
        @switch($order->status)
            @case('new') bg-primary @break
            @case('processing') bg-warning text-dark @break
            @case('completed') bg-success @break
            @case('cancelled') bg-danger @break
        @endswitch">
        @switch($order->status)
            @case('new') Новый @break
            @case('processing') В обработке @break
            @case('completed') Завершен @break
            @case('cancelled') Отменен @break
        @endswitch
    </span>
</p>
        <p><strong>Дата создания:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
        <p><strong>Общая сумма:</strong> {{ number_format($order->total, 2) }} ₽</p>
      </div>
      <div class="col-md-6">
        <h5 class="text-dark">Информация о клиенте</h5>
        <p><strong>Имя:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        <p><strong>Телефон:</strong> {{ $order->phone ?? 'Не указан' }}</p>
      </div>
      </div>

      <!-- Товары в заказе -->
      <h5 class="text-dark mb-3">Состав заказа</h5>
      <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="table-light">
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
          @if($item->product->image)
        <img src="{{ asset('assets/img/products/' . $item->product->image) }}"
        alt="{{ $item->product->name }}" width="150" class="me-3">
        @endif
          <div>
          <h6 class="mb-1">{{ $item->product->name }}</h6>
          <small class="text-muted">{{ $item->product->sku }}</small>
          </div>
        </div>
        </td>
        <td>{{ number_format($item->price, 2) }} ₽</td>
        <td>{{ $item->quantity }}</td>
        <td>{{ number_format($item->price * $item->quantity, 2) }} ₽</td>
        </tr>
      @endforeach
        </tbody>
        <tfoot>
        <tr>
          <td colspan="3" class="text-end"><strong>Итого:</strong></td>
          <td><strong>{{ number_format($order->total, 2) }} ₽</strong></td>
        </tr>
        </tfoot>
      </table>
      </div>

      <!-- Дополнительная информация -->
      <div class="row mt-4">
      <div class="col-md-6">
        <h5 class="text-dark mb-3">Доставка</h5>
        <p><strong>Способ:</strong> {{ $order->delivery_type }}</p>
        <p><strong>Адрес:</strong>
        @if($order->type == 'pickup')
      {{ config('app.shop_address') }}
      @else
      {{ $order->delivery_address ?? 'Адрес не указан' }}
      @endif
        </p>
        <p><strong>Комментарий:</strong> {{ $order->comment ?? 'Нет комментария' }}</p>
      </div>
      <div class="col-md-6">
        <h5 class="text-dark mb-3">Оплата</h5>
        <p><strong>Способ:</strong> Карта или наличные</p>
        <p><strong>Статус:</strong> Оплата после получения</p>
      </div>
      </div>

      <!-- Форма изменения статуса -->
      <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="mt-4">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col-md-4">
        <label class="form-label">Изменить статус</label>
        <select name="status" class="form-select">
          <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>Новый</option>
          <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>В обработке</option>
          <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Завершен</option>
          <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
        </select>
        </div>
        <div class="col-md-8 d-flex align-items-end">
        <button type="submit" class="btn-go" style="width: 200px;">
           Обновить статус
        </button>
        </div>
      </div>
      </form>
    </div>
    </div>
  </div>
@endsection