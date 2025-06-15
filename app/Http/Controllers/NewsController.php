<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('mycustomrole:wartawan')->only(['create', 'store']);
        $this->middleware('mycustomrole:editor')->only(['approve', 'reject']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $news = News::with(['category', 'author'])
            ->where(function($q) use ($user) {
                $q->where('status', 'published');
                if ($user->isWartawan()) {
                    $q->orWhere('user_id', $user->id);
                }
            })
            ->latest()->paginate(10);
        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = auth()->id();
        $data['status'] = 'draft';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            Image::make($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save(public_path('uploads/news/' . $filename));
            
            $data['image'] = $filename;
        }

        News::create($data);

        return redirect()->route('news.index')
            ->with('success', 'Berita berhasil dibuat dan menunggu persetujuan editor.');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $this->authorize('update', $news);
        $categories = Category::all();
        return view('news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $this->authorize('update', $news);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            Image::make($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save(public_path('uploads/news/' . $filename));
            
            $data['image'] = $filename;
        }

        $news->update($data);

        return redirect()->route('news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $this->authorize('delete', $news);
        $news->delete();

        return redirect()->route('news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function approve(News $news)
    {
        $news->update([
            'status' => 'published',
            'approved_by' => auth()->id(),
            'published_at' => now()
        ]);

        return redirect()->route('news.index')
            ->with('success', 'Berita berhasil dipublikasikan.');
    }

    public function reject(News $news)
    {
        $news->update([
            'status' => 'rejected',
            'approved_by' => auth()->id()
        ]);

        return redirect()->route('news.index')
            ->with('success', 'Berita ditolak untuk dipublikasikan.');
    }
}
