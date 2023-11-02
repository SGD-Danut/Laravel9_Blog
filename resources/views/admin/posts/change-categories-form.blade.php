@extends('admin.template.master-page')

@section('head-title', 'Schimbare categorie pentru postare')

@section('big-title')
    Schimbare categorie pentru postarea: <span class="text-info">{{ $post->title }}</span>
@endsection

@section('content')
    <form action="{{ route('admin.change-categories', $post->id) }}" method="POST">
        @csrf
        @method('put')
        @foreach ($categories as $category)
        <div class="mb-3">
            <input class="form-check-input" type="checkbox" value="{{ $category->id }}" id="check-{{ $category->id }}" name="categories[]" {{ $post->categories()->find($category->id) ? 'checked' : ''}}>
            <label class="form-check-label" for="check-{{ $category->id }}">
                {{ $category->title }}
            </label>
        </div>    
        @endforeach
        <div class="mb-3 mx-auto col-lg-3">
            <button type="submit" class="btn btn-primary">Schimbare categorii postare</button>
        </div>
    </form>
@endsection