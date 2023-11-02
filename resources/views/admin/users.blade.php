@extends('admin.template.master-page')

@section('head-title', 'Utilizatori')

@section('big-title', 'Utilizatori')

@section('content')
    <a href="{{ route('new-user-form') }}">
        <button type="button" class="btn btn-success new-user-button">Utilizator nou</button>
    </a>
    <table class="table" id="datatables">
        <thead>
            <tr>
            <th scope="col">Verificat</th>
            <th scope="col">Nume:</th>
            <th scope="col">Email:</th>
            <th scope="col">Adresă / Telefon:</th>
            <th scope="col" class="text-center">Fotografie:</th>
            <th scope="col">Rol:</th>
            <th scope="col">Creat la:</th>
            <th scope="col">Acțiuni:</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{!! $user->hasVerifiedEmail() ? '<i class="bi bi-person-check-fill text-info"> Da</i>' : '<i class="bi bi-person-check text-warning"> Nu</i>' !!}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{ $user->address }}
                        {{ $user->phone }}
                    </td>
                    <td><img src="/images/users/{{ $user->photo }}" class="userPhoto mx-auto" alt="Imagine utilizator"></td>
                    <td>
                        @if ($user->role == 'author')
                            <a href="{{ route('admin.posts', ['author' => $user->id]) }}" title="Vezi postări utilizator">{{ $user->role }} ({{ $user->posts->count() }})</a>
                            @else
                            {{ $user->role }}
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d.m.Y') }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Action buttons">
                            <a href="{{ route('edit-user-form', $user->id) }}"><button type="button" class="btn btn-primary">Editare</button></a>
                            <form id="delete-user-form-with-id-{{ $user->id }}" action="{{ route('delete-user', $user->id) }}" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                            <button type="button" class="btn btn-danger" onclick="
                            if(confirm('Sigur ștergeți utilizatorul: {{ $user->name }}?')) {
                                document.getElementById('delete-user-form-with-id-' + {{ $user->id }}).submit();
                            }
                            ">Ștergere</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('datatables-scripts')
    @include('admin.parts.datatables-scripts')
@endsection