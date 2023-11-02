@extends('front.template.master-page')

@section('meta_title', 'Toate postările')

{{-- @section('big-title', 'Toate postările') --}}

@section('content')
    @isset($allPostsTitle)
        @include('front.parts.posts-list', ['pages' => $posts, 'title' => $allPostsTitle ])
    @endisset
    {{-- Cod pentru afișare postările unui anumit autor: --}}
    @isset($author)
        @include('front.parts.posts-list', ['pages' => $posts, 'title' => $author ])
    @endisset
    {{-- Cod adăugat acum: --}}
    @isset($searchPostTerm)
        @include('front.parts.posts-list', ['pages' => $posts, 'title' => $searchPostTerm ])
    @endisset
@endsection