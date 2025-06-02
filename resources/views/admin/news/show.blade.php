@extends('layouts.admin')

@section('content')
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Просмотр новости</h5>
        <div>
            <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Редактировать
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <h2>{{ $news->title }}</h2>
                <div class="d-flex align-items-center mb-4">
                    <span class="badge {{ $news->is_published ? 'bg-success' : 'bg-secondary' }} me-2">
                        {{ $news->is_published ? 'Опубликовано' : 'Черновик' }}
                    </span>
                    <span class="text-muted">
                        {{ $news->published_at?->format('d.m.Y H:i') }}
                    </span>
                </div>
                
                @if($news->image)
                <div class="mb-4">
                    <img src="{{ asset('storage/'.$news->image) }}" class="img-fluid rounded" alt="{{ $news->title }}">
                </div>
                @endif
                
                <div class="news-content">
                    {!! $news->content !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Дополнительная информация</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Категория:</strong> {{ $news->category->name }}</p>
                        <p><strong>Дата создания:</strong> {{ $news->created_at->format('d.m.Y H:i') }}</p>
                        <p><strong>Последнее обновление:</strong> {{ $news->updated_at->format('d.m.Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection