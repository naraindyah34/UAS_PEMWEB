@extends('adminlte::page')

@section('title', 'Daftar Kategori')

@section('content_header')
    <h1>Daftar Kategori</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Berita</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td>{{ $category->news_count }}</td>
                                <td>
                                    <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-info">Lihat</a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $categories->links() }}
        </div>
    </div>
@stop 