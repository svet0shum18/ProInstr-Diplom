@extends('layouts.admin')

@section('content')

@section('title', 'Создание новости')

<div class="body-container mt-4">

 <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Профиль</a></li>
      <li class="breadcrumb-item active" aria-current="page">Создание новости</li>
    </ol>
</nav>

<h1 class="mb-4">Создать новость</h1>

<div class="row">

<div class="col-md-3">
      <!-- Левое меню -->
      @include('partials.admin_menu')

    </div>

     <div class="col-md-9">

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 text-dark">Создание новости</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Заголовок</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Категория</label>
                <select class="form-control" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                        <label class="form-label">Краткое описание</label>
                        <textarea class="form-control rounded-6 @error('description') is-invalid @enderror" 
                                  name="description" rows="3" required>{{ old('description') }}</textarea>
                        <small class="text-muted">Максимум 500 символов</small>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
            
            <div class="mb-3">
                <label class="form-label">Полный текст</label>
                <textarea class="form-control rounded-5" name="text" rows="10" required></textarea>
            </div>
                       <div class="mb-3">
                <label class="form-label">Изображение</label>
                <input type="file" class="form-control" name="img">
            </div>
            
            <button type="submit" class="btn-go" style="width: 200px">Сохранить</button>
        </form>
    </div>
</div>
</div>
</div>
</div>
@endsection