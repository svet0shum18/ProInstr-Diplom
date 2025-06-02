@extends('layouts.admin')

@section('title', 'Новости')

@section('content')
<div class="body-container mt-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Профиль</a></li>
      <li class="breadcrumb-item active" aria-current="page">Действия с новостями</li>
    </ol>
    </nav>

    <h1 class="mb-4">Новости на сайте</h1>

    <div class="row">
      <div class="col-md-3">
      <!-- Левое меню -->
      @include('partials.admin_menu')

    </div>
    <div class="col-md-9">

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-dark">Список новостей</h5>
        <a href="{{ route('admin.news.create') }}" class="text-success fw-bold">
            <i class="fas fa-plus"></i> Добавить новость
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Заголовок</th>
                        <th>Категория</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ Str::limit($item->title, 50) }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->created_at?->format('d.m.Y H:i') }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-info me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $news->links() }}
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection