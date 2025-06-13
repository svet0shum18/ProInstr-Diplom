@extends('layouts.main')

@section('title', 'Климатическое оборудование')

@section('content')

<h1 class="text-center mt-4">Климатическое оборудование</h1>
  <div class="category-cards mt-4">
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/klimat/conditioners/img1.jpg') }}" alt="кондиционеры" style="width: 180px;">
      <a href="{{ route('products.conditioners') }}" class="category-card h3 mt-4">Кондиционеры</a>
    </div>

    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/klimat/waterheater/img1.jpg') }}" alt="водонагреватели" style="width: 180px;">
      <a href="{{ route('products.waterheaters') }}" class="category-card h3 mt-4">Водонагреватели</a>
    </div>
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/klimat/heater/img1.jpg') }}" alt="обогреватели" style="width: 180px;">
      <a href="{{ route('products.heaters') }}" class="category-card h3 mt-4">Обогреватели</a>
    </div>
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/klimat/fan/img1.jpg') }}" alt="вентиляторы" style="width: 180px;">
    <a href="{{ route('products.fan') }}" class="category-card h3 mt-4">Вентиляторы</a>
    </div>
    <div class="card d-flex align-items-center">
      <img src="{{ asset('assets/img/products/klimat/heatguns/img1.jpg') }}" alt="тепловые пушки" style="width: 180px;">
    <a href="{{ route('products.heatguns') }}" class="category-card h3 mt-4">Тепловые пушки</a>
    </div>
  
  
 
  
  
</div>
@endsection