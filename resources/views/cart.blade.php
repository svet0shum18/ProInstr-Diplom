@extends('layouts.main')

@section('title', 'Корзина')

@section('content')



<div class="cart-container">
    <h2>Корзина</h2>
    @if(session('cart'))
        <table class="table">
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Итого</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('cart') as $id => $details)
                    <tr>
                        <td>{{ $details['name'] }}</td>
                        <td>{{ $details['price'] }} ₽</td>
                        <td>{{ $details['quantity'] }}</td>
                        <td>{{ $details['price'] * $details['quantity'] }} ₽</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3>Итог: {{ array_sum(array_column(session('cart'), 'price')) }} ₽</h3>
    @else
        <p>Ваша корзина пуста</p>
    @endif
</div>

@endsection