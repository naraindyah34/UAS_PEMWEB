@extends('layouts.adminlte')
@section('title', 'Menu Utama')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white font-weight-bold">Menu Utama Website</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-tachometer-alt fa-2x mb-2 text-primary"></i>
                                <h5 class="card-title">Dashboard</h5>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-block">Buka Dashboard</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-user fa-2x mb-2 text-primary"></i>
                                <h5 class="card-title">Profile</h5>
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-block">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-newspaper fa-2x mb-2 text-primary"></i>
                                <h5 class="card-title">News</h5>
                                <a href="{{ route('news.index') }}" class="btn btn-outline-primary btn-block">Lihat News</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-list fa-2x mb-2 text-primary"></i>
                                <h5 class="card-title">Categories</h5>
                                <a href="{{ route('categories.index') }}" class="btn btn-outline-primary btn-block">Lihat Categories</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-home fa-2x mb-2 text-primary"></i>
                                <h5 class="card-title">Home</h5>
                                <a href="{{ route('home') }}" class="btn btn-outline-primary btn-block">Ke Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 