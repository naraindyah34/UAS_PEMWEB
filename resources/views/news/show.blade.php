@extends('adminlte::page')

@section('title', $news->title)

@section('content_header')
    <h1>{{ $news->title }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <strong>Kategori:</strong> {{ $news->category->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Penulis:</strong> {{ $news->author->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge badge-{{ $news->status === 'published' ? 'success' : ($news->status === 'draft' ? 'warning' : 'danger') }}">
                            {{ $news->status }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <strong>Tanggal Dibuat:</strong> {{ $news->created_at->format('d/m/Y H:i') }}
                    </div>
                    @if($news->published_at)
                        <div class="mb-3">
                            <strong>Tanggal Dipublikasikan:</strong> {{ $news->published_at->format('d/m/Y H:i') }}
                        </div>
                    @endif
                    @if($news->approver)
                        <div class="mb-3">
                            <strong>Disetujui oleh:</strong> {{ $news->approver->name }}
                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    @if($news->image)
                        <img src="{{ asset('uploads/news/' . $news->image) }}" alt="{{ $news->title }}" class="img-fluid">
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <h4>Konten</h4>
                <div class="content">
                    {!! $news->content !!}
                </div>
            </div>

            <div class="mt-4">
                @if(auth()->user()->isWartawan() && $news->user_id === auth()->id())
                    <a href="{{ route('news.edit', $news) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('news.destroy', $news) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                    </form>
                @endif
                @if(auth()->user()->isEditor() && $news->status === 'draft')
                    <form action="{{ route('news.approve', $news) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">Setujui</button>
                    </form>
                    <form action="{{ route('news.reject', $news) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </form>
                @endif
                <a href="{{ route('news.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .content {
            line-height: 1.6;
        }
        .content img {
            max-width: 100%;
            height: auto;
        }
    </style>
@stop 