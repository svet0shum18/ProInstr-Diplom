@extends('layouts.main')

@section('title', 'Результаты поиска')

@section('content')
<div class="body_container mt-4">
    <h1 class="mb-4">Результаты поиска</h1>
    
    @if(request('query'))
        <div class="text-secondary mb-4 h5">
            Найдено товаров: {{ $products->total() }} по запросу "{{ $query }}"
        </div>
    @endif

    @if($products->isEmpty())
        <div class="text-secondary mb-4 h5">
            Товары по вашему запросу не найдены. Попробуйте изменить критерии поиска.
        </div>
    @else
        <div class="row">
            @foreach($products as $product)
                 <div class="col-lg-3 col-md-6 mt-4"> <!-- Колонки для 4 карточек в строке -->
      <div class="product-card h-100" style="width: auto;"> <!-- Добавляем h-100 для одинаковой высоты -->
      <img src="{{ asset('assets/img/products/' . $product->image) }}" alt="{{ $product->name }}"
        class="product-image img-fluid">
      <div class="product-info">
        <a href="{{ route('products.show', $product->id) }}">
        <h3 class="product-name">{{ $product->name }}</h3>
        </a>
        <p class="product-description">{{ $product->short_description }}</p>
        <p class="product-price">Цена: {{ number_format($product->price, 0, '', ' ') }} ₽</p>
      </div>
      <div class="product-actions">
        <form action="{{ route('favorite.add', ['product' => $product->id]) }}" method="POST">
        @csrf
        <button type="submit" data-product-id="{{ $product->id }}" class="add-to-fav">
        <i class="fa-solid fa-heart solid-heart fa-xl"></i>
        </button>
        </form>
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
        @csrf
        <button type="submit" class="add-to-cart ms-5" data-id="{{ $product->id }}">
        <i class="fa-solid fa-cart-shopping"></i>
        </button>
        </form>
      </div>
      </div>
      </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $products->appends(['query' => $query])->links() }}
        </div>
    @endif
</div>
@endsection