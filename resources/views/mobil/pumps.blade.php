@extends('layouts.main')

@section('title', 'Насосное оборудование')

@section('content')

<h1 class="text-center mt-4">Насосное оборудование</h1>
  <div class="category-cards mt-4">
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/pump/img1.jpg') }}" alt="Центробежные насосы" style="width: 180px;">
      <a href="{{ route('products.pump') }}" class="category-card h3 mt-4">Центробежные насосы</a>
    </div>

    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/pump/img2.jpg') }}" alt="Винтовые насосы" style="width: 180px;">
      <a href="{{ route('products.pump') }}" class="category-card h3 mt-4">Винтовые насосы</a>
    </div>
    <div class="card mb-3 d-flex align-items-center">
      <img src="{{ asset('assets/img/products/pump/img3.jpg') }}" alt="Вибрационные насосы" style="width: 180px;">
      <a href="{{ route('products.pump') }}" class="category-card h3 mt-4">Вибрационные насосы</a>
    </div>
    <div class="card d-flex align-items-center">
      <img src="{{ asset('assets/img/products/pump/img4.jpg') }}" alt="Криогенные насосы" style="width: 180px;">
    <a href="{{ route('products.pump') }}" class="category-card h3 mt-4">Криогенные насосы</a>
    </div>

  
 
  
  
</div>
@endsection