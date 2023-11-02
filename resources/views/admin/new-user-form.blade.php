@extends('admin.template.master-page')

@section('head-title', 'Adăugare utilizator')

@section('big-title', 'Adăugare utilizator')

@section('content')
    <form action="{{ route('create-new-user') }}" method="POST" class="col-lg-3 mx-auto" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="InputName" class="form-label">Nume complet</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="InputName" aria-describedby="nameHelp" name="name" value="{{ old('name') }}">
            @error('name')
                <div id="nameHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputEmail" class="form-label">Adresă de email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="InputEmail" aria-describedby="emailHelp" name="email" value="{{ old('email') }}">
            @error('email')
            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputAddress" class="form-label">Adresă</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="InputAddress" aria-describedby="addressHelp" name="address" value="{{ old('address') }}">
            @error('address')
                <div id="addressHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputPhone" class="form-label">Nr. telefon</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="InputPhone" aria-describedby="phoneHelp" name="phone" value="{{ old('phone') }}">
            @error('phone')
                <div id="phoneHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="SelectRole" class="form-label">Rol</label>
            <select class="form-select" aria-label="Select role" name="role" value="{{ old('role') }}">
                <option value="admin">Administrator</option>
                <option value="author" selected>Autor</option>
                <option value="editor">Editor</option>
            </select>
            @error('role')
                <div id="roleHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputPassword" class="form-label">Parolă</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="InputPassword" name="password">
            @error('password')
            <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="InputConfirmPassword" class="form-label">Confirmare parolă</label>
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="InputConfirmPassword" name="password_confirmation">
            @error('password_confirmation')
                <div id="passwordHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="ValidateEmail" class="form-label">Validare email</label>
            <div class="form-check text-start">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefaultForEmailValidation" name="validateEmail">
                <label class="form-check-label" for="flexCheckDefaultForEmailValidation">Email validat</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="photo-file" class="form-label">Fotografie</label>
                <div class="mb-3 rounded mx-auto d-block" id="image-preview">
                    <img src="\images\users\defaultUserPhoto.png" class="img-thumbnail" alt="Imagine utilizator">
                </div>
            <input class="form-control" type="file" accept="image/*" id="photo-file" name="photo">
            @error('photo')
                <div id="photoHelp" class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Adaugă utilizator</button>
    </form> 
@endsection

@section('image-preview-script')
    @include('admin.parts.image-preview-script')
@endsection