@extends('layouts.admin')

@section('title', 'Управление заказами')

@section('content')

  <div class="body-container mt-4">

    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Профиль</a></li>
      <li class="breadcrumb-item active" aria-current="page">Просмотр заказов</li>
    </ol>
    </nav>
    <h1 class="mb-4">Оформленные заказы</h1>

    <div class="row">

    <div class="col-md-3">
      <!-- Левое меню -->
      @include('partials.admin_menu')

    </div>

    <div class="col-md-9">

    <div class="card mb-4">
      <div class="card-header py-3 d-flex justify-content-between">
      <h5 class="m-0 font-weight-bold text-dark">Список заказов</h5>
      <div class="dropdown">
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Фильтры
        </button>
        <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => null]) }}">Все заказы</a>
        </li>
        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'new']) }}">Новые</a></li>
        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'processing']) }}">В
          обработке</a></li>
        <li><a class="dropdown-item"
          href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}">Завершенные</a></li>
        </ul>
      </div>
      </div>
      <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered">
        <thead>
          <tr>
          <th>№ заказа</th>
          <th>Клиент</th>
          <th>Сумма</th>
          <th>Статус</th>
          <th>Дата</th>
          <th>Действия</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
        <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->user->name }}</td>
        <td>{{ number_format($order->total, 2) }} ₽</td>
        <td>
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="d-inline">
        @csrf
        @method('PUT')
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>Новый</option>
          <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>В обработке
          </option>
          <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Завершен</option>
          <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
        </select>
        </form>
        </td>
        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
        <td>
        <a href="{{ route('admin.orders.show', $order->id) }}" class="fw-bold text-primary">
        Подробнее о заказе
        </a>
        </td>
        </tr>
      @endforeach
        </tbody>
        </table>
        {{ $orders->links() }}
      </div>
      </div>
    </div>
    </div>
    </div>
  </div>
@endsection