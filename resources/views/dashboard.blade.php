@extends('layouts.adminlte')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="alert alert-info">
        <h4>Selamat datang, {{ auth()->user()->name }}!</h4>
        <p>Anda login sebagai: <strong>{{ ucfirst(auth()->user()->role) }}</strong></p>
    </div>

    <h1 class="mb-4">Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\News::count() }}</h3>
                    <p>Berita</p>
                </div>
                <div class="icon">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\Category::count() }}</h3>
                    <p>Kategori</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \App\Models\User::count() }}</h3>
                    <p>User</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 