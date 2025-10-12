<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Gd\Driver;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = News::with(['category', 'author', 'tags']);

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            if ($request->status === 'published') {
                $query->whereNotNull('published_at')->where('published_at', '<=', now());
            } elseif ($request->status === 'draft') {
                $query->whereNull('published_at');
            } elseif ($request->status === 'scheduled') {
                $query->whereNotNull('scheduled_at')->where('scheduled_at', '>', now());
            }
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = NewsCategory::all();

        return view('admin.news.index', compact('news', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = NewsCategory::all();
        $tags = Tag::all();
        return view('admin.news.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:news_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'excerpt' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'publish_status' => 'required|in:draft,publish,schedule',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $data = $request->all();

        // Generate slug
        $data['slug'] = Str::slug($request->title);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            
            // Store original image
            $image->storeAs('public/news', $imageName);
            
            // Create thumbnail directory if not exists
            if (!file_exists(storage_path('app/public/news/thumbnails'))) {
                mkdir(storage_path('app/public/news/thumbnails'), 0755, true);
            }
            
            // For now, just copy the original image as thumbnail
            // TODO: Implement proper image resizing later
            $thumbnailName = 'thumb_' . $imageName;
            $sourcePath = storage_path('app/public/news/' . $imageName);
            $destPath = storage_path('app/public/news/thumbnails/' . $thumbnailName);
            
            if (file_exists($sourcePath)) {
                if (!copy($sourcePath, $destPath)) {
                    \Log::warning("Failed to copy thumbnail for news image: {$imageName}");
                }
            } else {
                \Log::warning("Source image not found for thumbnail: {$sourcePath}");
            }
            
            $data['image'] = $imageName;
        }

        // Handle publish status
        if ($request->publish_status === 'publish') {
            $data['published_at'] = now();
        } elseif ($request->publish_status === 'schedule' && $request->scheduled_at) {
            $data['scheduled_at'] = $request->scheduled_at;
        }

        // Set author
        $data['author_id'] = auth()->id();

        // Auto-generate excerpt if not provided
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($request->content), 150);
        }

        $news = News::create($data);

        // Attach tags
        if ($request->has('tags')) {
            $news->tags()->attach($request->tags);
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $news->load(['category', 'author', 'tags']);
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $categories = NewsCategory::all();
        $tags = Tag::all();
        $news->load('tags');
        return view('admin.news.edit', compact('news', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:news_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'excerpt' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'publish_status' => 'required|in:draft,publish,schedule',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $data = $request->all();

        // Generate slug if title changed
        if ($news->title !== $request->title) {
            $data['slug'] = Str::slug($request->title);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image) {
                Storage::delete('public/news/' . $news->image);
                Storage::delete('public/news/thumbnails/thumb_' . $news->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            
            // Store original image
            $image->storeAs('public/news', $imageName);
            
            // Create thumbnail directory if not exists
            if (!file_exists(storage_path('app/public/news/thumbnails'))) {
                mkdir(storage_path('app/public/news/thumbnails'), 0755, true);
            }
            
            // For now, just copy the original image as thumbnail
            // TODO: Implement proper image resizing later
            $thumbnailName = 'thumb_' . $imageName;
            $sourcePath = storage_path('app/public/news/' . $imageName);
            $destPath = storage_path('app/public/news/thumbnails/' . $thumbnailName);
            
            if (file_exists($sourcePath)) {
                if (!copy($sourcePath, $destPath)) {
                    \Log::warning("Failed to copy thumbnail for news image: {$imageName}");
                }
            } else {
                \Log::warning("Source image not found for thumbnail: {$sourcePath}");
            }
            
            $data['image'] = $imageName;
        }

        // Handle publish status
        if ($request->publish_status === 'publish') {
            $data['published_at'] = now();
            $data['scheduled_at'] = null;
        } elseif ($request->publish_status === 'schedule' && $request->scheduled_at) {
            $data['scheduled_at'] = $request->scheduled_at;
            $data['published_at'] = null;
        } elseif ($request->publish_status === 'draft') {
            $data['published_at'] = null;
            $data['scheduled_at'] = null;
        }

        // Auto-generate excerpt if not provided
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($request->content), 150);
        }

        $news->update($data);

        // Sync tags
        if ($request->has('tags')) {
            $news->tags()->sync($request->tags);
        } else {
            $news->tags()->detach();
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Delete image files
        if ($news->image) {
            Storage::delete('public/news/' . $news->image);
            Storage::delete('public/news/thumbnails/thumb_' . $news->image);
        }

        // Detach tags
        $news->tags()->detach();

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(News $news)
    {
        $news->update(['is_featured' => !$news->is_featured]);
        
        return response()->json([
            'success' => true,
            'is_featured' => $news->is_featured
        ]);
    }

    /**
     * Bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,publish,draft',
            'news_ids' => 'required|array',
            'news_ids.*' => 'exists:news,id'
        ]);

        $newsIds = $request->news_ids;

        switch ($request->action) {
            case 'delete':
                News::whereIn('id', $newsIds)->delete();
                $message = 'Berita berhasil dihapus.';
                break;
            case 'publish':
                News::whereIn('id', $newsIds)->update(['published_at' => now()]);
                $message = 'Berita berhasil dipublikasikan.';
                break;
            case 'draft':
                News::whereIn('id', $newsIds)->update(['published_at' => null]);
                $message = 'Berita berhasil dijadikan draft.';
                break;
        }

        return redirect()->route('admin.news.index')->with('success', $message);
    }
}