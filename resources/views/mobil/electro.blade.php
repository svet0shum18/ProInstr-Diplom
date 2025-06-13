@extends('layouts.main')

@section('title', 'Электроинструменты')

@section('content')

<h1 class="text-center mt-4">Электро-инструменты</h1>
  <div class="category-cards mt-4">
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/electro/drill/img1.jpg') }}" alt="Наборы инструментов" style="width: 180px;">
      <a href="{{ route('products.drill') }}" class="category-card h3 mt-4">Дрели</a>
    </div>

    <div class="card mb-3 d-flex align-items-center text-center">
      <img src="{{ asset('assets/img/products/electro/puncher/img1.jpg') }}" alt="Автомобильный инструмент" style="width: 180px;">
      <a href="{{ route('products.puncher') }}" class="category-card h3 mt-4">Перфораторы</a>
    </div>
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/electro/bolgar/img1.jpg') }}" alt="Ящики для инструментов" style="width: 180px;">
      <a href="{{ route('products.bolgar') }}" class="category-card h3 mt-4">Болгарки</a>
    </div>
    <div class="card d-flex align-items-center">
      <img src="{{ asset('assets/img/products/electro/wallchaser/img1.jpg') }}" alt="Отвертки" style="width: 180px;">
    <a href="{{ route('products.wallchaser') }}" class="category-card h3 mt-4">Штроборезы</a>
    </div>

  
 
  
  
</div>
@endsection