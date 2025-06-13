@extends('layouts.main')

@section('title', 'Сварочное оборудование')

@section('content')

<h1 class="text-center mt-4">Сварочное оборудование</h1>
  <div class="category-cards mt-4">
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/welding/img1.jpg') }}" alt="Наборы инструментов" style="width: 180px;">
      <a href="{{ route('products.welding') }}" class="category-card h3 mt-4">Дуговая сварка</a>
    </div>

    <div class="card mb-3 d-flex align-items-center text-center">
      <img src="{{ asset('assets/img/products/welding/img2.jpg') }}" alt="Автомобильный инструмент" style="width: 180px;">
      <a href="{{ route('products.welding') }}" class="category-card h3 mt-4">Контактная сварка</a>
    </div>
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/welding/img3.jpg') }}" alt="Ящики для инструментов" style="width: 180px;">
      <a href="{{ route('products.welding') }}" class="category-card h3 mt-4">Газопламенная сварка</a>
    </div>
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/welding/img4.jpg') }}" alt="Отвертки" style="width: 180px;">
    <a href="{{ route('products.welding') }}" class="category-card h3 mt-4">Холодная сварка</a>
    </div>
    <div class="card d-flex align-items-center">
      <img src="{{ asset('assets/img/products/welding/img1.jpg') }}" alt="Отвертки" style="width: 180px;">
    <a href="{{ route('products.welding') }}" class="category-card h3 mt-4">Лазерная сварка</a>
    </div>

  
 
  
  
</div>
@endsection