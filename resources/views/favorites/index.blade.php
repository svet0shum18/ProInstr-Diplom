@extends('layouts.main')

@section('title', 'Избранное')

@section('content')
    <div class="body-container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Профиль</a></li>
                <li class="breadcrumb-item active" aria-current="page">Избранное</li>
            </ol>
        </nav>
        <h1 class="zag-section mb-4">Избранные товары</h1>
        <div class="row">
            <div class="col-md-3">
                @include('partials.profile_menu')
            </div>

            <div class="col-md-">
                <div class="d-flex justify-content-start gap-4 w-100">
                    @forelse($favorites as $favorite)
                        @php $product = $favorite->product; @endphp
                        <div class="product-card" style="width: 256px;">
                            <img src="{{ asset('assets/img/products/' . $product->image) }}" alt="{{ $product->name }}"
                                class="product-image">
                            <div class="product-info">
                                <a class="product-name" href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
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
                        <div class="d-flex justify-content-center w-100 gap-2 h5">
                            В избранном пока что пусто! <a href="{{ url('/') }}" class="fw-bold link-success"> Начать
                                покупки</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection