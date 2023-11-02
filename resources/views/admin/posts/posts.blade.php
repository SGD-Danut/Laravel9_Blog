@extends('admin.template.master-page')

@section('head-title', 'Postări')

@section('font-awesome-cdn')
    @include('admin.parts.font-awesome-cdn')
@endsection

{{-- Ale cui sunt postările pe care am dat click - metodă doar Blade --}}
{{-- @if (!request('author'))
    @section('big-title', 'Postări')
@else
    @if (request('author'))
        @section('big-title')
            Postări: {{ $posts[0]->author->name }}
        @endsection
    @endif
@endif --}}

@if (isset($nameOfSelectedCategory))
    @section('big-title')
        S-au găsit {{ $posts->total() }} postări din categoria <span class="text-info">{{ $nameOfSelectedCategory }}</span> 
    @endsection   
@endif

@if (isset($searchedPost))
    @section('big-title')
        S-au găsit {{ $posts->total() }} postări după termenul <span class="text-info">{{ $searchedPost }}</span> 
    @endsection   
@endif


@if (isset($postsStatus))
    @section('big-title')
        Postări {{ $postsStatus }}
    @endsection   
@endif

@section('content')
    @if (!isset($authorName))
        @section('big-title', 'Postări')
    @else
        @if (isset($authorName))
            @section('big-title')
                Postări: {{ $authorName }}
            @endsection
        @endif
    @endif
    
    <h5>Filtrează postări după categorie:</h5>
    @foreach ($categories as $category)
        <a href="{{ route('admin.posts', ['category' => $category->id]) }}"><span class="badge text-bg-warning">{{ $category->title }}</span></a>
    @endforeach

    @can('only-admin-and-author-have-rights')
        <a href="{{ route('admin.new-post-form') }}">
            <button type="button" class="btn btn-success new-post-button">Postare nouă</button>
        </a>
    @endcan
    @if ($posts->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col"><i class="fa-solid fa-file-lines"></i></th>
                    <th scope="col">@sortablelink('title', 'Titlu') / @sortablelink('created_at', 'Creat la:')</th>
                    <th scope="col">Autor:</th>
                    <th scope="col" class="text-center">Imagine:</th>
                    <th scope="col">@sortablelink('views', 'Vizualizări:')</th>
                    <th scope="col">Meta Desc / Categorii postare:</th>
                    <th scope="col">Acțiuni:</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($posts as $post)
                    <tr class="{{--{{ $post->published_at != null ? 'bg-light' : 'bg-warning' }}--}}">
                        <td>
                            @if (isset($post->published_at))
                                <a href="{{ route('admin.posts', ['published' => 'public']) }}"><i class="fa-solid fa-file-lines text-success"></i></a>
                            @else
                                <a href="{{ route('admin.posts', ['published' => 'private']) }}"><i class="fa-solid fa-file-lines text-warning"></i></a>
                            @endif
                        </td>
                        <td><b>{{ $post->title }}</b><br> {{ $post->created_at->format('d.m.Y - H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.posts', ['author' => $post->author->id]) }}">
                            {{ $post->author->name }} ({{$post->author->posts->count()}})
                            </a>
                        </td>
                        <td><img src="/images/posts/{{ $post->image }}" class="postImage mx-auto" alt="Imagine postare"></td>
                        <td>{{ $post->views }}</td>
                        <td>
                            <span class="text-primary">{{ $post->meta_description }}</span><br>
                            @foreach ($post->categories->sortBy('title') as $category)
                                <span class="badge text-bg-secondary">{{ $category->title }}</span>
                            @endforeach
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Action buttons">
                                <a href="{{ route('admin.edit-post-form', $post->id) }}"><button type="button" class="btn btn-primary">Editare</button></a>
                                <a href="{{ route('admin.change-categories-form', $post->id) }}"><button type="button" class="btn btn-info">Categorii</button></a>
                                @can('only-admin-and-author-have-rights')
                                    <form id="delete-post-form-with-id-{{ $post->id }}" action="{{ route('admin.delete-post', $post->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                    </form>
                                    <button type="button" class="btn btn-danger" onclick="
                                    if(confirm('Sigur ștergeți postarea: {{ $post->title }}?')) {
                                        document.getElementById('delete-post-form-with-id-' + {{ $post->id }}).submit();
                                    }
                                    ">Ștergere</button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $posts->links() }}
        {{--Mai jos avem alternativa pentru link-uri paginatie + nu mai avem nevoie sa folosim withQueryString() 
            în funcția showPosts() din controller: --}}
        {{-- {!! $posts->appends(\Request::except('page'))->render() !!} --}}
    @else
        <div class="alert alert-warning"><h5>Nu sunt potări de afișat!</h5></div>
    @endif
@endsection

{{-- Tailwind CSS CDNs: --}}
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" integrity="sha512-wnea99uKIC3TJF7v4eKk4Y+lMz2Mklv18+r4na2Gn1abDRPPOeef95xTzdwGD9e6zXJBteMIhZ1+68QC5byJZw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}