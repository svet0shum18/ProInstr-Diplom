@extends('layouts.admin')

@section('content')

@section('title', 'Добавление товара')


<div class="body-container mt-4">

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Профиль</a></li>
      <li class="breadcrumb-item active" aria-current="page">Добавление товара</li>
    </ol>
    </nav>

    <h1 class="mb-4">Добавить товар</h1>

     <div class="row">

     <div class="col-md-3">
      <!-- Левое меню -->
      @include('partials.admin_menu')

    </div>

    <div class="col-md-9">

<div class="card shadow">
    <div class="card-header py-3">
        <h5 class="text-dark fw-bold">Добавление нового товара</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Левая колонка -->
                <div class="col-md-6">
                    <!-- Основная информация -->
                    <div class="mb-3">
                        <label class="form-label">Название товара</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Модель</label>
                        <input type="text" class="form-control @error('model') is-invalid @enderror" 
                               name="model" value="{{ old('model') }}" required>
                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Краткое описание</label>
                        <textarea class="form-control rounded-4 @error('short_description') is-invalid @enderror" 
                                  name="short_description" rows="3" required>{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Полное описание</label>
                        <textarea class="form-control rounded-4 @error('full_description') is-invalid @enderror" 
                                  name="full_description" rows="5" required>{{ old('full_description') }}</textarea>
                        @error('full_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Правая колонка -->
                <div class="col-md-6">
                    <!-- Технические характеристики -->
                    <div class="mb-3">
                        <label class="form-label">Цена (₽)</label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                               name="price" value="{{ old('price') }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Мощность (Вт)</label>
                        <input type="number" class="form-control" 
                               name="power" value="{{ old('power') }}">
                       
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Вес (кг)</label>
                        <input type="number" step="0.1" class="form-control @error('weight') is-invalid @enderror" 
                               name="weight" value="{{ old('weight') }}">
                        @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Количество на складе</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                               name="quantity" value="{{ old('quantity') }}" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Выбор категорий -->
                    <div class="mb-3">
                        <label class="form-label">Изображение товара</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               name="image" accept="image/*" required>
                        <small class="text-muted">Формат: JPEG, PNG. Макс. размер: 2MB</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Связанные сущности -->
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Тип инструмента</label>
                        <select class="form-select @error('tool_type_id') is-invalid @enderror" 
                                name="tool_type_id" required>
                            <option value="">Выберите тип</option>
                            @foreach($toolTypes as $type)
                                <option value="{{ $type->id }}" {{ old('tool_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('tool_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Бренд</label>
                        <select class="form-select @error('brand_id') is-invalid @enderror" 
                                name="brand_id" required>
                            <option value="">Выберите бренд</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Категория</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                name="category_id" required>
                            <option value="">Выберите категорию</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn-go" style="width: 200px;">
            Сохранить товар
                </button>
            </div>
        </form>
    </div>
    </div>
</div>
</div>
</div>

@endsection