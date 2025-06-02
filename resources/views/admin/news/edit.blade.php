@extends('layouts.admin')

@section('content')
<div class="card shadow">
    <div class="card-header">
        <h5 class="mb-0">Редактирование новости</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Заголовок</label>
                <input type="text" class="form-control" name="title" value="{{ old('title', $news->title) }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Категория</label>
                <select class="form-select" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ $category->id == $news->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Изображение</label>
                @if($news->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$news->image) }}" width="200" class="img-thumbnail">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image">
                        <label class="form-check-label" for="remove_image">Удалить изображение</label>
                    </div>
                </div>
                @endif
                <input type="file" class="form-control" name="image">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Содержание</label>
                <textarea class="form-control ckeditor" name="content" rows="10" required>{{ old('content', $news->content) }}</textarea>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="is_published" id="is_published" 
                    value="1" {{ $news->is_published ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published">Опубликовано</label>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Отмена</a>
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </div>
        </form>
    </div>
</div>
@endsection