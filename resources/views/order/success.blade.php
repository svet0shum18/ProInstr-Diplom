@extends('layouts.main')

@section('title', 'Заказ оформлен')

@section('content')
<div class="container-body mt-4">
<h2 class="zag-section mt-4 text-center">Заказ успешно оформлен!</h2>
<p class="mb-0 opacity-75 text-center">Спасибо, что выбрали Нас.</p>

<div class="card-cart mt-3">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h3 class="h5 mb-3">Детали заказа</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>Номер заказа:</strong> #{{ $order->id }}</li>
                                <li class="mb-2"><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</li>
                                <li class="mb-2"><strong>Статус:</strong> <span class="badge bg-success">Оформлен</span></li>
                                <li><strong>Сумма:</strong> {{ number_format($order->total, 0, '', ' ') }} ₽</li>
                            </ul>
                        </div>
                        
                        @if($order->delivery)
                        <div class="col-md-6">
                            <h3 class="h5 mb-3">Доставка</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>Способ:</strong> {{ $order->type === 'delivery' ? 'Доставка' : 'Самовывоз' }}</li>
                                @if($order->type === 'delivery')
                                <li class="mb-2"><strong>Адрес:</strong> {{ $order->delivery->city }}, ул. {{ $order->delivery->street }}, д. {{ $order->delivery->house }}, кв. {{ $order->delivery->apartment }}</li>
                                <li class="mb-2"><strong>Дата доставки:</strong> {{ \Carbon\Carbon::parse($order->delivery->delivery_date)->format('d.m.Y') }}</li>
                                <li class="mb-2"><strong>Время:</strong> {{ str_replace('-', ' - ', $order->delivery->time_interval) }}</li>
                                <li class="mb-2"><strong>Получатель:</strong> {{ $order->delivery->full_name }}</li>
                                <li><strong>Номер телефона:</strong>{{ $order->delivery->phone }}</li>
                                @else
                                <li class="mb-2"><strong>Адрес магазина:</strong> г. Владивосток, ул. Лермонтова, 70</li>
                                <li class="mb-2"><strong>Дата получения:</strong> {{ \Carbon\Carbon::parse($order->delivery_date)->format('d.m.Y') }}</li>
                                <li class="mb-2"><strong>Номер телефона:</strong>{{ $order->delivery->phone }}</li>
                                <li><strong>Получатель:</strong> {{ $order->delivery->full_name }}</li>
                                @endif
                            </ul>
                        </div>
                        @endif
                    </div>
                    
                    <hr class="my-4">
                    
                    <h3 class="h5 mb-3">Состав заказа</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Товар</th>
                                    <th class="text-end">Цена</th>
                                    <th class="text-end">Кол-во</th>
                                    <th class="text-end">Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/img/product/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid rounded me-3" width="60">
                                            <div>
                                                <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                <small class="text-muted">Арт. {{ $item->product->article }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">{{ number_format($item->price, 0, '', ' ') }} ₽</td>
                                    <td class="text-end">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ number_format($item->price * $item->quantity, 0, '', ' ') }} ₽</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <th colspan="3" class="text-end">Итого:</th>
                                    <th class="text-end">{{ number_format($order->total, 0, '', ' ') }} ₽</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
</div>
@endsection