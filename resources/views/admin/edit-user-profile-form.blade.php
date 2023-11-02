@extends('admin.template.master-page')

@section('head-title', 'Editare profil')

@section('content')
    {{-- <h1 class="display-6 fw-bold">Editare profil utilizator: {{ $user->name }}</h1> --}}
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Editare profil</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Schimbare parolă</button>
        </li>
        {{-- <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Contact</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>Disabled</button>
        </li> --}}
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <h2 class="display-9 fw-bold">Editare profil: {{ $user->name }}</h2>
            <br>
            <form action="{{ route('update-user-profile') }}" method="POST" class="col-lg-3 mx-auto" enctype="multipart/form-data" id="edit-profile-form">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="InputName" class="form-label">Nume complet</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="InputName" aria-describedby="nameHelp" name="name" value="{{ $user->name }}">
                    @error('name')
                        <div id="nameHelp" class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="InputEmail" class="form-label">Adresă de email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="InputEmail" aria-describedby="emailHelp" name="email" value="{{ $user->email }}">
                    @error('email')
                    <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="InputAddress" class="form-label">Adresă</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="InputAddress" aria-describedby="addressHelp" name="address" value="{{ $user->address }}">
                    @error('address')
                        <div id="addressHelp" class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="InputPhone" class="form-label">Nr. telefon</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="InputPhone" aria-describedby="phoneHelp" name="phone" value="{{ $user->phone }}">
                    @error('phone')
                        <div id="phoneHelp" class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="photo-file" class="form-label">Fotografie</label>
                        <div class="mb-3 rounded mx-auto d-block" id="image-preview">
                            <img src="{{ '/images/users/' . $user->photo }}" class="img-thumbnail" alt="Imagine utilizator">
                        </div>
                    <input class="form-control" type="file" accept="image/*" id="photo-file" name="photo">
                    @error('photo')
                        <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Actualizare profil</button>
            </form>
        </div>
        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
            <h2 class="display-9 fw-bold">Schimbare parolă: {{ $user->name }}</h2>
            <br>
            <form action="{{ route('update-password') }}" method="POST" class="col-lg-3 mx-auto" enctype="multipart/form-data" id="change-password-form">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="InputPassword" class="form-label">Parolă actuală</label>
                    <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="InputPassword" name="old_password">
                    @error('old_password')
                        <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                <div class="mb-3">
                    <label for="InputPassword" class="form-label">Noua parolă</label>
                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="InputPassword" name="new_password">
                    @error('new_password')
                    <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="InputConfirmPassword" class="form-label">Confirmare noua parolă</label>
                    <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="InputConfirmPassword" name="new_password_confirmation">
                    @error('new_password_confirmation')
                        <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Schimbare parolă</button>
            </form>
        </div>
        {{-- <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
        <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div> --}}
    </div>
@endsection 
 
@section('image-preview-script')
    @include('admin.parts.image-preview-script')
@endsection
