@extends('layouts.main')

@section('title', 'Избранное')

@section('content')
<div class="body_container mt-4">
<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Профиль</a></li>
            <li class="breadcrumb-item active" aria-current="page">Избранное</li>
        </ol>
    </nav>
<h2 class="zag-section">Избранные товары</h2>

<div class="product-container mt-4">
    @forelse($favorites as $favorite)
        @php $product = $favorite->product; @endphp
        <div class="product-card">
            <img src="{{ asset('assets/img/product/' . $product->image) }}" alt="Product Image" class="product-image">
            <div class="product-info">
                <h3 class="product-name">{{ $product->name }}</h3>
                <p class="product-description">{{ $product->description }}</p>
                <p class="product-price">Цена: {{ $product->price }} ₽</p>

                <form action="{{ route('favorite.remove', ['product' => $product->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="add-to-fav">
                        <i class="fa-solid fa-heart-crack fa-xl"></i>
                    </button>
                </form>

                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="add-to-cart" data-id="{{ $product->id }}">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p>У вас нет избранных товаров.</p>
    @endforelse
</div>
</div>

@endsection
