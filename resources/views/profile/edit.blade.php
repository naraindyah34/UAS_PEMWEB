@extends('layouts.adminlte')

@section('title', 'Edit Profile')

@section('content')
<div class="container" style="max-width: 500px;">
    <h1 class="mb-4">Edit Profile</h1>
    @if(auth()->user()->profile_photo)
        <div class="mb-3 text-center">
            <img src="{{ asset('uploads/profile/' . auth()->user()->profile_photo) }}" alt="Foto Profil" class="img-thumbnail" style="max-width:120px;">
            <form action="{{ route('profile.delete_photo') }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm mt-2">Hapus Foto</button>
            </form>
        </div>
    @endif
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group mb-3">
            <label for="name">Nama</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="profile_photo">Foto Profil <small class="text-muted">(opsional)</small></label>
            <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" accept="image/*">
        </div>
        <div class="form-group mb-3">
            <label for="password">Password Baru <small class="text-muted">(kosongkan jika tidak ingin ganti)</small></label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
        </div>
        <div class="form-group mb-4">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection 