@extends('layouts.main')

@section('title', 'Мои заказы')

@section('content')
<div class="container mt-4">
<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Профиль</a></li>
            <li class="breadcrumb-item active" aria-current="page">Мои заказы</li>
        </ol>
    </nav>
    <h1 class="mb-4">Мои заказы</h1>

    @if($orders->isEmpty())
        <div class="alert alert-info">
            У вас пока нет заказов. <a href="#" class="alert-link">Начать покупки</a>
        </div>
    @else
        <div class="row">
            @foreach($orders as $order)
            <div class="col-md-6 mb-4">
                <div class="card order-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark">Заказ #{{ $order->id }}</h5>
                        <span class="badge 
                            @if($order->status == 'new') bg-primary
                            @elseif($order->status == 'processing') bg-warning text-dark
                            @elseif($order->status == 'completed') bg-success
                            @elseif($order->status == 'cancelled') bg-danger
                            @endif">
                            {{ $order->status_text }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <small class="text-muted">Дата заказа</small>
                                <p class="mb-0">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">Сумма</small>
                                <p class="mb-0 fw-bold">{{ number_format($order->total, 0, '', ' ') }} ₽</p>
                            </div>
                        </div>

                        <h6 class="mt-3 mb-2">Состав заказа:</h6>
                        <div class="order-items">
                            @foreach($order->items->take(3) as $item)
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset('assets/img/product/' . $item->product->image) }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="img-thumbnail me-2" 
                                     width="50">
                                <div class="flex-grow-1">
                                    <p class="mb-0 small">{{ $item->product->name }}</p>
                                    <p class="mb-0 text-muted small">{{ $item->quantity }} × {{ number_format($item->price, 0, '', ' ') }} ₽</p>
                                </div>
                            </div>
                            @endforeach

                            @if($order->items->count() > 3)
                            <div class="text-center mt-2">
                                <small class="text-muted">+ ещё {{ $order->items->count() - 3 }} товаров</small>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                Подробнее о заказе
                            </a>
                            @if($order->status == 'new')
                            <form action="#" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Отменить заказ
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
</div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .order-card {
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }
    .order-card:hover {
        transform: translateY(-5px);
    }
    .order-items {
        max-height: 200px;
        overflow-y: auto;
        padding-right: 10px;
    }
    .order-items::-webkit-scrollbar {
        width: 5px;
    }
    .order-items::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 10px;
    }
    .badge {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
</style>
@endpush