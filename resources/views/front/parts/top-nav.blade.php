<div class="container fixed-top">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    {{-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.all-categories') }}">{{ __('All categories') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('Categories') }}
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($menuCategories as $category)
                            <li><a class="dropdown-item" href="{{ route('front.current-category', $category->slug) }}">{{ $category->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.all-posts', ['posts' => 'all']) }}">{{ __('All posts') }}</a>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <form action="{{ route('front.all-posts') }}" class="d-flex" role="search">
                        @csrf
                        <input name="searchPostTerm" class="form-control me-2" type="search" placeholder="Caută postare..." aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Caută</button>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
</div>