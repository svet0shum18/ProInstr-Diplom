@extends('layouts.main')

@section('content')
    <h2>Корзина</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
                <tr id="cart-item-{{ $item->id }}">
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->product->price }} ₽</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->product->price * $item->quantity }} ₽</td>
                    <td>
                        <form action="{{ route('cart.update', $item->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            <input type="hidden" name="change" value="1">
                            <button type="submit">+</button>
                        </form>

                        <form action="{{ route('cart.update', $item->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            <input type="hidden" name="change" value="-1">
                            <button type="submit">−</button>
                        </form>

                        <form action="{{ route('cart.remove', $item->product_id) }}" method="POST"
                            style="display:inline-block;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Итого: {{ $totalSum }} ₽</h3>

@endsection