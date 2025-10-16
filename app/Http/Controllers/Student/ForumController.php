<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\AcademicYear;

class ForumController extends Controller
{
    /**
     * Display forum dashboard.
     */
    public function index(Request $request)
    {
        $student = Auth::user()->profile;
        $currentYear = $this->getCurrentAcademicYear();
        
        // Get filter parameters
        $search = $request->get('search', '');
        $category = $request->get('category', '');
        $status = $request->get('status', '');
        $sort = $request->get('sort', 'latest');
        
        // Get forum data
        $topics = $this->getTopics($student, $search, $category, $status, $sort);
        
        // Get statistics
        $stats = $this->getForumStats($student);
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities($student);
        
        // Get popular topics
        $popularTopics = $this->getPopularTopics($student);
        
        // Get categories
        $categories = $this->getCategories();
        
        // Get filter options
        $filterOptions = $this->getFilterOptions($student);
        
        return view('student.forum.index', compact(
            'topics',
            'stats',
            'recentActivities',
            'popularTopics',
            'categories',
            'filterOptions',
            'search',
            'category',
            'status',
            'sort'
        ));
    }
    
    /**
     * Display specific topic.
     */
    public function show($id)
    {
        $student = Auth::user()->profile;
        $topic = $this->getTopicById($id);
        
        if (!$topic) {
            abort(404, 'Topik tidak ditemukan');
        }
        
        // Get topic details
        $topicDetails = $this->getTopicDetails($topic);
        
        // Get replies
        $replies = $this->getReplies($topic);
        
        // Get related topics
        $relatedTopics = $this->getRelatedTopics($topic);
        
        return view('student.forum.show', compact(
            'topic',
            'topicDetails',
            'replies',
            'relatedTopics'
        ));
    }
    
    /**
     * Create new topic.
     */
    public function create()
    {
        $student = Auth::user()->profile;
        $categories = $this->getCategories();
        
        return view('student.forum.create', compact('categories'));
    }
    
    /**
     * Store new topic.
     */
    public function store(Request $request)
    {
        $student = Auth::user()->profile;
        
        // Validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'category' => 'required|string|in:academic,general,help,announcement',
            'tags' => 'nullable|string|max:255',
            'is_pinned' => 'boolean',
            'is_locked' => 'boolean'
        ]);
        
        // Create topic (placeholder)
        $topic = (object)[
            'id' => rand(1000, 9999),
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'tags' => $request->tags ? explode(',', $request->tags) : [],
            'author' => $student->user->name,
            'author_id' => $student->id,
            'created_at' => now(),
            'updated_at' => now(),
            'views' => 0,
            'replies_count' => 0,
            'likes_count' => 0,
            'is_pinned' => $request->is_pinned ?? false,
            'is_locked' => $request->is_locked ?? false,
            'status' => 'active'
        ];
        
        return response()->json([
            'message' => 'Topik berhasil dibuat',
            'topic' => $topic,
            'success' => true,
            'redirect' => route('student.forum.show', $topic->id)
        ]);
    }
    
    /**
     * Reply to topic.
     */
    public function reply(Request $request, $id)
    {
        $student = Auth::user()->profile;
        $topic = $this->getTopicById($id);
        
        if (!$topic) {
            abort(404, 'Topik tidak ditemukan');
        }
        
        // Validate request
        $request->validate([
            'content' => 'required|string|max:2000',
            'parent_id' => 'nullable|integer'
        ]);
        
        // Create reply (placeholder)
        $reply = (object)[
            'id' => rand(1000, 9999),
            'content' => $request->content,
            'author' => $student->user->name,
            'author_id' => $student->id,
            'topic_id' => $id,
            'parent_id' => $request->parent_id,
            'created_at' => now(),
            'likes_count' => 0,
            'is_solution' => false
        ];
        
        return response()->json([
            'message' => 'Balasan berhasil dikirim',
            'reply' => $reply,
            'success' => true
        ]);
    }
    
    /**
     * Like/unlike topic or reply.
     */
    public function like(Request $request, $type, $id)
    {
        $student = Auth::user()->profile;
        
        // Validate request
        $request->validate([
            'action' => 'required|string|in:like,unlike'
        ]);
        
        // Placeholder for like/unlike logic
        $action = $request->action;
        $message = $action === 'like' ? 'Berhasil disukai' : 'Berhasil tidak disukai';
        
        return response()->json([
            'message' => $message,
            'action' => $action,
            'success' => true
        ]);
    }
    
    /**
     * Mark reply as solution.
     */
    public function markSolution(Request $request, $topicId, $replyId)
    {
        $student = Auth::user()->profile;
        $topic = $this->getTopicById($topicId);
        
        if (!$topic) {
            abort(404, 'Topik tidak ditemukan');
        }
        
        // Check if user is topic author
        if ($topic->author_id !== $student->id) {
            abort(403, 'Anda tidak memiliki izin untuk menandai solusi');
        }
        
        return response()->json([
            'message' => 'Balasan berhasil ditandai sebagai solusi',
            'success' => true
        ]);
    }
    
    /**
     * Get current academic year.
     */
    private function getCurrentAcademicYear()
    {
        return AcademicYear::where('is_active', true)->first() ?? 
               AcademicYear::latest()->first();
    }
    
    /**
     * Get topics with filters.
     */
    private function getTopics($student, $search, $category, $status, $sort)
    {
        // Placeholder data - implement with actual topics
        $topics = collect([
            (object)[
                'id' => 1,
                'title' => 'Cara Menyelesaikan Soal Matematika Kelas 7',
                'content' => 'Saya mengalami kesulitan dalam menyelesaikan soal matematika tentang aljabar. Ada yang bisa bantu?',
                'category' => 'academic',
                'tags' => ['matematika', 'aljabar', 'kelas-7'],
                'author' => 'Ahmad Rizki',
                'author_id' => 1,
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(1),
                'views' => 45,
                'replies_count' => 8,
                'likes_count' => 12,
                'is_pinned' => false,
                'is_locked' => false,
                'status' => 'active',
                'last_reply' => (object)[
                    'author' => 'Bu Sari',
                    'created_at' => now()->subMinutes(30)
                ]
            ],
            (object)[
                'id' => 2,
                'title' => 'Pengumuman Penting: Ujian Tengah Semester',
                'content' => 'Ujian Tengah Semester akan dilaksanakan pada tanggal 15-20 Maret 2024. Silakan persiapkan diri dengan baik.',
                'category' => 'announcement',
                'tags' => ['pengumuman', 'uts', 'ujian'],
                'author' => 'Admin Sekolah',
                'author_id' => 999,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
                'views' => 156,
                'replies_count' => 3,
                'likes_count' => 25,
                'is_pinned' => true,
                'is_locked' => false,
                'status' => 'active',
                'last_reply' => (object)[
                    'author' => 'Siti Nurhaliza',
                    'created_at' => now()->subHours(3)
                ]
            ],
            (object)[
                'id' => 3,
                'title' => 'Tips Belajar Efektif di Rumah',
                'content' => 'Bagikan tips dan trik belajar yang efektif di rumah. Apa saja yang kalian lakukan untuk tetap fokus?',
                'category' => 'general',
                'tags' => ['tips', 'belajar', 'efektif'],
                'author' => 'Maya Sari',
                'author_id' => 2,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(1),
                'views' => 89,
                'replies_count' => 15,
                'likes_count' => 18,
                'is_pinned' => false,
                'is_locked' => false,
                'status' => 'active',
                'last_reply' => (object)[
                    'author' => 'Rizki Pratama',
                    'created_at' => now()->subHours(5)
                ]
            ],
            (object)[
                'id' => 4,
                'title' => 'Bantuan: Cara Upload Tugas di Portal',
                'content' => 'Saya bingung cara upload tugas di portal. Ada yang bisa jelaskan step by step?',
                'category' => 'help',
                'tags' => ['bantuan', 'upload', 'tugas', 'portal'],
                'author' => 'Dewi Kartika',
                'author_id' => 3,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(2),
                'views' => 67,
                'replies_count' => 5,
                'likes_count' => 8,
                'is_pinned' => false,
                'is_locked' => false,
                'status' => 'active',
                'last_reply' => (object)[
                    'author' => 'Pak Budi',
                    'created_at' => now()->subDays(1)
                ]
            ],
            (object)[
                'id' => 5,
                'title' => 'Diskusi: Proyek IPA Kelompok',
                'content' => 'Mari diskusikan proyek IPA kelompok kita. Siapa yang punya ide untuk eksperimen?',
                'category' => 'academic',
                'tags' => ['ipa', 'proyek', 'kelompok', 'eksperimen'],
                'author' => 'Fajar Nugroho',
                'author_id' => 4,
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(3),
                'views' => 34,
                'replies_count' => 7,
                'likes_count' => 6,
                'is_pinned' => false,
                'is_locked' => false,
                'status' => 'active',
                'last_reply' => (object)[
                    'author' => 'Sari Indah',
                    'created_at' => now()->subDays(2)
                ]
            ]
        ]);
        
        // Apply filters
        if ($search) {
            $topics = $topics->filter(function($item) use ($search) {
                return stripos($item->title, $search) !== false || 
                       stripos($item->content, $search) !== false ||
                       in_array(strtolower($search), array_map('strtolower', $item->tags));
            });
        }
        
        if ($category) {
            $topics = $topics->filter(function($item) use ($category) {
                return $item->category === $category;
            });
        }
        
        if ($status) {
            $topics = $topics->filter(function($item) use ($status) {
                return $item->status === $status;
            });
        }
        
        // Apply sorting
        switch ($sort) {
            case 'latest':
                $topics = $topics->sortByDesc('created_at');
                break;
            case 'oldest':
                $topics = $topics->sortBy('created_at');
                break;
            case 'popular':
                $topics = $topics->sortByDesc('views');
                break;
            case 'most_replies':
                $topics = $topics->sortByDesc('replies_count');
                break;
            case 'most_likes':
                $topics = $topics->sortByDesc('likes_count');
                break;
        }
        
        return $topics;
    }
    
    /**
     * Get forum statistics.
     */
    private function getForumStats($student)
    {
        return [
            'total_topics' => 25,
            'total_replies' => 156,
            'total_views' => 2847,
            'my_topics' => 3,
            'my_replies' => 12,
            'my_likes' => 45,
            'categories' => [
                'academic' => 12,
                'general' => 8,
                'help' => 3,
                'announcement' => 2
            ]
        ];
    }
    
    /**
     * Get recent activities.
     */
    private function getRecentActivities($student)
    {
        return collect([
            (object)[
                'id' => 1,
                'type' => 'topic_created',
                'title' => 'Topik baru dibuat',
                'description' => 'Cara Menyelesaikan Soal Matematika',
                'author' => 'Ahmad Rizki',
                'created_at' => now()->subHours(2)
            ],
            (object)[
                'id' => 2,
                'type' => 'reply_added',
                'title' => 'Balasan baru',
                'description' => 'Tips Belajar Efektif di Rumah',
                'author' => 'Maya Sari',
                'created_at' => now()->subHours(4)
            ],
            (object)[
                'id' => 3,
                'type' => 'topic_liked',
                'title' => 'Topik disukai',
                'description' => 'Pengumuman Penting: UTS',
                'author' => 'Admin Sekolah',
                'created_at' => now()->subDays(1)
            ]
        ]);
    }
    
    /**
     * Get popular topics.
     */
    private function getPopularTopics($student)
    {
        return collect([
            (object)[
                'id' => 1,
                'title' => 'Cara Menyelesaikan Soal Matematika',
                'views' => 45,
                'replies' => 8,
                'likes' => 12
            ],
            (object)[
                'id' => 2,
                'title' => 'Tips Belajar Efektif di Rumah',
                'views' => 89,
                'replies' => 15,
                'likes' => 18
            ],
            (object)[
                'id' => 3,
                'title' => 'Pengumuman Penting: UTS',
                'views' => 156,
                'replies' => 3,
                'likes' => 25
            ]
        ]);
    }
    
    /**
     * Get categories.
     */
    private function getCategories()
    {
        return [
            'academic' => 'Akademik',
            'general' => 'Umum',
            'help' => 'Bantuan',
            'announcement' => 'Pengumuman'
        ];
    }
    
    /**
     * Get filter options.
     */
    private function getFilterOptions($student)
    {
        return [
            'categories' => ['academic', 'general', 'help', 'announcement'],
            'statuses' => ['active', 'locked', 'archived'],
            'sorts' => ['latest', 'oldest', 'popular', 'most_replies', 'most_likes']
        ];
    }
    
    /**
     * Get topic by ID.
     */
    private function getTopicById($id)
    {
        $topics = $this->getTopics(Auth::user()->profile, '', '', '', '');
        return $topics->where('id', $id)->first();
    }
    
    /**
     * Get topic details.
     */
    private function getTopicDetails($topic)
    {
        return [
            'formatted_date' => $topic->created_at->format('d M Y H:i'),
            'time_ago' => $topic->created_at->diffForHumans(),
            'category_label' => $this->getCategories()[$topic->category] ?? $topic->category,
            'tags_string' => implode(', ', $topic->tags),
            'is_author' => $topic->author_id === Auth::user()->profile->id
        ];
    }
    
    /**
     * Get replies for topic.
     */
    private function getReplies($topic)
    {
        return collect([
            (object)[
                'id' => 1,
                'content' => 'Untuk soal aljabar, coba mulai dengan mengelompokkan variabel yang sama. Misalnya 2x + 3x = 5x.',
                'author' => 'Bu Sari',
                'author_id' => 999,
                'created_at' => now()->subHours(1),
                'likes_count' => 5,
                'is_solution' => false,
                'parent_id' => null
            ],
            (object)[
                'id' => 2,
                'content' => 'Saya setuju dengan Bu Sari. Jangan lupa untuk selalu cek jawaban dengan substitusi nilai x.',
                'author' => 'Ahmad Rizki',
                'author_id' => 1,
                'created_at' => now()->subMinutes(30),
                'likes_count' => 3,
                'is_solution' => false,
                'parent_id' => null
            ],
            (object)[
                'id' => 3,
                'content' => 'Terima kasih Bu Sari, sekarang saya sudah paham!',
                'author' => 'Maya Sari',
                'author_id' => 2,
                'created_at' => now()->subMinutes(15),
                'likes_count' => 1,
                'is_solution' => false,
                'parent_id' => 1
            ]
        ]);
    }
    
    /**
     * Get related topics.
     */
    private function getRelatedTopics($topic)
    {
        $allTopics = $this->getTopics(Auth::user()->profile, '', '', '', '');
        return $allTopics->filter(function($item) use ($topic) {
            return $item->id !== $topic->id && $item->category === $topic->category;
        })->take(3);
    }
}








