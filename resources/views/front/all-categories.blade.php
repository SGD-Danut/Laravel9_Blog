@extends('front.template.master-page')

@section('meta_title', 'Toate categoriile')

@section('big-title', 'Toate categoriile')

@section('content')
    <div class="row row-cols-1 row-cols-md-6 g-4">
      @foreach ($categories as $category)
        <div class="col">
          <div class="card">
            <a href="{{ route('front.current-category', $category->slug) }}">
              <img src="\images\categories\{{ $category->image }}" class="card-img-top" alt="Imagien categorie">
            </a>
            <div class="card-body">
              <h5 class="card-title">{{ $category->title }}</h5>
              <p class="card-text">{{ $category->subtitle }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
@endsection