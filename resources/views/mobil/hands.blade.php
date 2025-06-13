@extends('layouts.main')

@section('title', 'Ручной инструмент')

@section('content')

<h1 class="text-center mt-4">Ручной инструмент</h1>
  <div class="category-cards mt-4">
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/handtools/tools/img1.jpg') }}" alt="Наборы инструментов" style="width: 180px;">
      <a href="{{ route('products.tools') }}" class="category-card h3 mt-4">Наборы инструментов</a>
    </div>

    <div class="card mb-3 d-flex align-items-center text-center">
      <img src="{{ asset('assets/img/products/handtools/autotools/img1.jpg') }}" alt="Автомобильный инструмент" style="width: 180px;">
      <a href="{{ route('products.autotools') }}" class="category-card h3 mt-4">Автомобильный инструмент</a>
    </div>
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/handtools/toolbox/img1.jpg') }}" alt="Ящики для инструментов" style="width: 180px;">
      <a href="{{ route('products.toolbox') }}" class="category-card h3 mt-4">Ящики для инструментов</a>
    </div>
    <div class="card d-flex align-items-center">
      <img src="{{ asset('assets/img/products/handtools/screwdriver/img1.jpg') }}" alt="Отвертки" style="width: 180px;">
    <a href="{{ route('products.screwdriver') }}" class="category-card h3 mt-4">Отвертки</a>
    </div>

  
 
  
  
</div>
@endsection