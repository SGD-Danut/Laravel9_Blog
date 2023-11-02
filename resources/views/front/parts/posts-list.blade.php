{{-- Listă postări ==> --}}
<h1 class="display-6 fw-bold">{{ $title }}</h1>
<br>
{{ $pages->links() }}
<div class="row row-cols-1 row-cols-md-3 g-4">
  @foreach ($pages as $post)
  <div class="col">
    <div class="card">
      <div class="image-container">
          <span class="badge bg-secondary">Postarea nr: {{ request('page') ? $loop->iteration + ($pages->perPage() * (request('page') - 1)) : $loop->iteration }}</span>
      <a href="{{ route('front.current-post', $post->slug) }}">
        <img src="/images/posts/{{ $post->image }}" style="width: 150px" class="card-img-top rounded mx-auto d-block" alt="Imagine postare" title="{{ $post->meta_description }}">
      </a>
      </div>
      <div class="card-body mt-2">
        <a href="{{ route('front.current-post', $post->slug) }}" class="text-decoration-none">
          <h5 class="card-title">{{ $post->title }}</h5>
        </a>
        <h5 class="card-title"><span class="text-info">Autor: </span><a href="{{ route('front.all-posts', ['author' => $post->author->id]) }}" class="text-decoration-none">{{ $post->author->name }}</a></h5>
        <h6>{{ $post->subtitle }}</h6>
        <p class="card-text">{!! $post->presentation !!}</p>
        <p class="card-text"><span class="text-info">Vizualizări: </span><b>{{ $post->views }}</b></p>
        <p class="card-text"><small class="text-muted"><span class="text-info">Data publicării: </span>{{ $post->published_at->format('d.m.Y - H:i') }}</small></p>
      </div>
    </div>
  </div>
  @endforeach
</div>
<br>
{{ $pages->links() }}
{{-- <== Listă postări --}}