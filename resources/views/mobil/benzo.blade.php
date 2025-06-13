@extends('layouts.main')

@section('title', 'Бензоинструменты')

@section('content')

<h1 class="text-center mt-4 ">Бензоинструменты</h1>
  <div class="category-cards mt-4">
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/petrolTools/chainsaw/img1.png') }}" alt="бензопилы" style="width: 180px;">
      <a href="{{ route('products.chainsaw') }}" class="category-card h3 mt-4">Бензопилы</a>
    </div>

    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/petrolTools/generator/img1.jpg') }}" alt="генераторы" style="width: 180px;">
      <a href="{{ route('products.generator') }}" class="category-card h3 mt-4">Генераторы</a>
    </div>
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/petrolTools/benzorez/img1.jpg') }}" alt="бензорезы" style="width: 180px;">
      <a href="{{ route('products.benzorez') }}" class="category-card h3 mt-4">Бензорезы</a>
    </div>
    <div class="card d-flex align-items-center">
      <img src="{{ asset('assets/img/products/petrolTools/pomp/img1.jpg') }}" alt="мотопомпы" style="width: 180px;">
    <a href="{{ route('products.pomp') }}" class="category-card h3 mt-4">Мотопомпы</a>
    </div>
  
  
 
  
  
</div>
@endsection