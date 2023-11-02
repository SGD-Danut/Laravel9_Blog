@extends('front.template.master-page')

@section('meta_title', $category->meta_title)
@section('meta_description', $category->meta_description)
@section('meta_keywords', $category->meta_keywords)

@section('big-title', $category->title)

@section('content')
  <div class="card mb-3" style="max-width: 100%;">
      <div class="card-header">{{ $category->subtitle }}</div>
      <div class="row g-0">
        <div class="col-md-4">
          <img src="/images/categories/{{ $category->image }}" class="img-fluid rounded-start" alt="Imagine categorie {{ $category->title }}">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            {{-- <h5 class="card-title">{{ $category->subtitle }}</h5> --}}
            <div class="card-text text-start">{!! $category->presentation !!}</div>
            {{-- <p class="card-text"><small class="text-muted">Actualizat la: {{ $category->updated_at->format('d.m.Y - H:i') }}</small></p> --}}
          </div>
        </div>
      </div>
      <ul class="list-group list-group-flush">
          <li class="list-group-item text-muted">Actualizat la: {{ $category->updated_at->format('d.m.Y - H:i') }}</li>
          <li class="list-group-item">Vizualizări: {{ $category->views }}</li>
          {{-- <li class="list-group-item">A third item</li> --}}
      </ul>
  </div>
@include('front.parts.posts-list', ['pages' => $category->publicPosts(), 'title' => 'Postările acestei categorii:' ])
@endsection