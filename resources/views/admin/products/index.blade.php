@extends('layouts.admin')

@section('content')

@section('title', 'Товары')

<div class="body-container mt-4">

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Профиль</a></li>
      <li class="breadcrumb-item active" aria-current="page">Действия с товарами</li>
    </ol>
    </nav>

    <h1 class="mb-4">Список товаров</h1>

    <div class="row">

     <div class="col-md-3">
      <!-- Левое меню -->
      @include('partials.admin_menu')

    </div>

    <div class="col-md-9">

    <div class="card mb-4">

    <div class="card-header">
         <!-- Фильтр по категориям и кнопка добавления -->
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="m-0 font-weight-bold text-dark">Список товаров</h5>
       <div class="d-flex gap-3 justify-content-end align-items-center">
         <a href="{{ route('admin.products.create') }}" class="text-success fw-bold">
           <i class="fas fa-plus"></i> Добавить товар
          </a>
          <form method="GET" class="form-inline">
              <select name="category" class="btn-outline-secondary" onchange="this.form.submit()">
                  <option value="">Все категории</option>
                  @foreach($categories as $category)
                      <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                          {{ $category->name }}
                      </option>
                  @endforeach
              </select>
          </form>
        </div>
    </div>
    </div>
 

    <!-- Таблица товаров -->
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Изображение</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('assets/img/products/' . $product->image) }}" width="50" alt="{{ $product->name }}">
                            @else
                                <span class="text-muted">Нет фото</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ number_format($product->price, 2, '.', ' ') }} ₽</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            <span class="badge {{ $product->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->quantity > 0 ? 'В наличии' : 'Нет в наличии' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Товары не найдены</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
    </div>
    </div>
</div>
@endsection