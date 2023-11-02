<div class="container fixed-top">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                    </li>
                    @if (auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users') }}">{{ __('Users') }}</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.categories') }}">{{ __('Categories') }}</a>
                    </li>
                    {{-- Vechiul buton pt Postări --}}
                    {{-- <li class="nav-item">
                         <a class="nav-link" href="{{ route('admin.posts') }}">{{ __('Posts') }}</a> 
                    </li> --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('Posts') }}
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="{{ route('admin.posts') }}">Toate</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href="{{ route('admin.posts', ['published' => 'public']) }}">Publicate</a></li>
                          <li><a class="dropdown-item" href="{{ route('admin.posts', ['published' => 'private']) }}">Nepublicate</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <form action="{{ route('admin.posts') }}" class="d-flex" role="search">
                        @csrf
                        <input name="searchPostTerm" class="form-control me-2" type="search" placeholder="Caută postare..." aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Caută</button>
                    </form>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('edit-user-profile-form') }}">{{ __('User Profile') }}</a></li>
                            @if (auth()->user()->role == 'author')
                                <li><a class="dropdown-item" href="{{ route('admin.posts', ['author' => auth()->id()]) }}">{{ __('My Posts') }} ({{ auth()->user()->posts->count() }})</a></li>
                            @endif
                        
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
    
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </li>
                            </form>
                            {{-- <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>