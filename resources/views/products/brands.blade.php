@extends('layouts.main')

@section('title', "Товары бренда $brandName")

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Товары бренда: {{ ucfirst($brandName) }}</h1>
    
    @if($products->isEmpty())
        <div class="alert alert-info">
            Нет товаров этого бренда в каталоге
        </div>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price">{{ $product->price }} ₽</span>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-primary">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection