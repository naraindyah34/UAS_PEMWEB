@extends('adminlte::page')

@section('title', $category->name)

@section('content_header')
    <h1>{{ $category->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <h4>Deskripsi</h4>
                <p>{{ $category->description ?: 'Tidak ada deskripsi' }}</p>
            </div>

            <div class="mb-4">
                <h4>Berita dalam Kategori Ini</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->author->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $item->status === 'published' ? 'success' : ($item->status === 'draft' ? 'warning' : 'danger') }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('news.show', $item) }}" class="btn btn-sm btn-info">Lihat</a>
                                        @if(auth()->user()->isWartawan() && $item->user_id === auth()->id())
                                            <a href="{{ route('news.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('news.destroy', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                            </form>
                                        @endif
                                        @if(auth()->user()->isEditor() && $item->status === 'draft')
                                            <form action="{{ route('news.approve', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                                            </form>
                                            <form action="{{ route('news.reject', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $news->links() }}
            </div>

            <div class="mt-4">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                    </form>
                @endif
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@stop 