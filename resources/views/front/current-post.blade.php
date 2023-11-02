@extends('front.template.master-page')

@section('meta_title', $post->meta_title)
@section('meta_description', $post->meta_description)
@section('meta_keywords', $post->meta_keywords)

@section('big-title', $post->title)

@section('content')
  <h5>Categorii din care face parte postarea:</h5>
  @foreach ($post->publicCategories() as $category)
      <a href="{{ route('front.current-category', $category->slug) }}" class="badge text-bg-warning text-decoration-none">{{ $category->title }}</a>
  @endforeach
  {{-- @foreach ($post->categories->sortBy('title') as $category)
    <a href="{{ route('front.current-category', $category->slug) }}" class="badge text-bg-warning text-decoration-none">{{ $category->title }}</a>
  @endforeach --}}
  <br><br>
  <div class="card mb-3" style="max-width: 100%;">
      <div class="card-header">{{ $post->subtitle }}</div>
      <div class="row g-0">
        <div class="col-md-4">
          <img src="/images/posts/{{ $post->image }}" class="img-fluid rounded-start" alt="Imagine postare {{ $post->title }}" title="{{ $post->meta_description }}">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <div class="card-text text-start">{!! $post->content !!}</div>
          </div>
        </div>
      </div>
      <ul class="list-group list-group-flush">
          <li class="list-group-item text-muted">Dată publicare: {{ $post->published_at->format('d.m.Y - H:i') }}</li>
          <li class="list-group-item">Vizualizări: {{ $post->views }}</li>
          <li class="list-group-item">Autor: <a href="{{ route('front.all-posts', ['author' => $post->author->id]) }}" class="text-decoration-none">{{ $post->author->name }} ({{ $post->author->publicPosts()->count() }})</a></li>
      </ul>
  </div>
@endsection