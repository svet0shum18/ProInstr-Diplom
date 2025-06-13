@extends('layouts.main')

@section('title', 'Новости')

@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mt-4">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Главная</a></li>
      <li class="breadcrumb-item active">{{ $article->title}}</li>
    </ol>
    </nav>

<article class="news-article">
    <h2 class="mt-4">{{ $article->title }}</h2>
    <div class="meta">
        <span class="date">{{ $article->created_at->format('d.m.Y') }}</span>
        <span class="category">{{ $article->category->name }}</span>
    </div>
    <img src="{{ asset('assets/img/news/' . $article->img) }}" alt="{{ $article->title }}" class="mt-4 rounded-4" >
    <div class="content mt-4 mb-4" style="text-align: justify;">
        {!! $article->text !!}
    </div>
    
</article>

@endsection