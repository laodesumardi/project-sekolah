<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::withCount('news')->orderBy('usage_count', 'desc')->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        Tag::create($data);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $tag->load(['news' => function ($query) {
            $query->with(['category', 'author'])->orderBy('published_at', 'desc');
        }]);
        
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $data = $request->all();
        
        // Generate slug if name changed
        if ($tag->name !== $request->name) {
            $data['slug'] = Str::slug($request->name);
        }

        $tag->update($data);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // Detach from all news
        $tag->news()->detach();
        
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil dihapus.');
    }

    /**
     * Get tags for autocomplete (AJAX).
     */
    public function autocomplete(Request $request)
    {
        $query = $request->get('q');
        
        $tags = Tag::where('name', 'like', "%{$query}%")
            ->orderBy('usage_count', 'desc')
            ->limit(10)
            ->get(['id', 'name', 'color']);

        return response()->json($tags);
    }

    /**
     * Create tag from AJAX request.
     */
    public function createAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $tag = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'color' => $request->color ?? '#3B82F6',
        ]);

        return response()->json([
            'success' => true,
            'tag' => $tag
        ]);
    }
}