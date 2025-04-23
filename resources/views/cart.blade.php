@extends('layouts.main')

@section('title', 'Корзина')

@section('content')



<div class="cart-container">
    <h2 class="zag-section mt-4">Корзина</h2>
    @foreach($cartItems as $item)
    <div style="border: 1px solid #ccc; padding: 10px; margin: 10px;">
        <img src="{{ $item->product->image }}" width="100">
        <p>{{ $item->product->name }}</p>
        <p>Цена: {{ $item->product->price }} руб</p>
        <p>Количество: {{ $item->quantity }}</p>

        <form action="{{ route('cart.update', ['id' => $item->id, 'action' => 'add']) }}" method="POST">
            @csrf
            <button>Добавить</button>
        </form>

        <form action="{{ route('cart.update', ['id' => $item->id, 'action' => 'remove']) }}" method="POST">
            @csrf
            <button>Уменьшить</button>
        </form>

        <form action="{{ route('cart.delete', $item->id) }}" method="POST">
            @csrf
            <button>Удалить</button>
        </form>
    </div>
@endforeach

<p><strong>Итоговая сумма: 
    {{ $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    }) }} руб
</strong></p>

<form action="{{ route('cart.checkout') }}" method="POST">
    @csrf
    <button>Оформить заказ</button>
</form>

@endsection