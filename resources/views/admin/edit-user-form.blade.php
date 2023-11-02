@extends('admin.template.master-page')

@section('head-title', 'Editare utilizator')

@section('big-title')
    <h1 class="display-6 fw-bold">Editare utilizator: <span class="text-secondary">{{ $user->name }}</span></h1>
    {!! $user->hasVerifiedEmail() ? '<i class="bi bi-person-check-fill text-info"> Email verificat</i>' : '<i class="bi bi-person-check text-warning"> Email neverificat</i>' !!}
    <br><br>
@endsection

@section('content')
    <form action="{{ route('update-user', $user->id) }}" method="POST" class="col-lg-3 mx-auto" enctype="multipart/form-data">
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
            <label for="SelectRole" class="form-label">Rol</label>
            <select class="form-select" aria-label="Select role" name="role">
                <option value="admin" {{ $user->role == "admin" ? 'selected' : ''}}>Administrator</option>
                <option value="author" {{ $user->role == "author" ? 'selected' : ''}}>Autor</option>
                <option value="editor" {{ $user->role == "editor" ? 'selected' : ''}}>Editor</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="userEmailStatus" class="form-label">Stare confirmare email</label>
            <select class="form-select" aria-label="Select email action" name="userEmailAction">
                <option selected value="noAction">Nici-o acțiune</option>
                <option class="text-warning" value="notifyUserToConfirmEmail">Trimite notificare de confirmare email</option>
                <option class="text-success" value="validateEmail">Valideză email-ul</option>
                <option class="text-danger" value="invalidateEmail" >Invalideză email-ul</option>
            </select>
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
        <button type="submit" class="btn btn-primary">Actualizează utilizator</button>
    </form>
@endsection

@section('image-preview-script')
    @include('admin.parts.image-preview-script')
@endsection