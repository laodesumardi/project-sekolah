<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * Display the forum index page.
     */
    public function index()
    {
        $teacher = Auth::user()->profile;
        
        // Get forum categories
        $categories = $this->getForumCategories();
        
        // Get recent discussions
        $recentDiscussions = $this->getRecentDiscussions($teacher);
        
        // Get my discussions
        $myDiscussions = $this->getMyDiscussions($teacher);
        
        // Get forum statistics
        $stats = $this->getForumStats($teacher);
        
        // Get trending topics
        $trendingTopics = $this->getTrendingTopics();
        
        return view('teacher.forum.index', compact(
            'categories',
            'recentDiscussions',
            'myDiscussions',
            'stats',
            'trendingTopics'
        ));
    }
    
    /**
     * Show discussions in a specific category.
     */
    public function category($categoryId)
    {
        $teacher = Auth::user()->profile;
        
        // Get category details
        $category = $this->getCategoryDetails($categoryId);
        
        // Get discussions in category
        $discussions = $this->getCategoryDiscussions($categoryId);
        
        // Get category statistics
        $stats = $this->getCategoryStats($categoryId);
        
        return view('teacher.forum.category', compact(
            'category',
            'discussions',
            'stats'
        ));
    }
    
    /**
     * Show a specific discussion.
     */
    public function show($id)
    {
        $teacher = Auth::user()->profile;
        
        // Get discussion details
        $discussion = $this->getDiscussionDetails($id);
        
        // Get replies
        $replies = $this->getDiscussionReplies($id);
        
        // Get related discussions
        $relatedDiscussions = $this->getRelatedDiscussions($discussion->category_id);
        
        return view('teacher.forum.show', compact(
            'discussion',
            'replies',
            'relatedDiscussions'
        ));
    }
    
    /**
     * Show create discussion form.
     */
    public function create()
    {
        $teacher = Auth::user()->profile;
        
        // Get categories
        $categories = $this->getForumCategories();
        
        // Get classes for teacher
        $classes = $this->getTeacherClasses($teacher);
        
        return view('teacher.forum.create', compact(
            'categories',
            'classes'
        ));
    }
    
    /**
     * Store new discussion.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:forum_categories,id',
            'class_id' => 'nullable|exists:school_classes,id',
            'tags' => 'nullable|string',
            'is_pinned' => 'boolean',
            'is_anonymous' => 'boolean'
        ]);
        
        // In real implementation, save to database
        return response()->json([
            'success' => true,
            'message' => 'Diskusi berhasil dibuat',
            'redirect' => route('teacher.forum.index')
        ]);
    }
    
    /**
     * Show edit discussion form.
     */
    public function edit($id)
    {
        $teacher = Auth::user()->profile;
        
        // Get discussion details
        $discussion = $this->getDiscussionDetails($id);
        
        // Get categories
        $categories = $this->getForumCategories();
        
        // Get classes
        $classes = $this->getTeacherClasses($teacher);
        
        return view('teacher.forum.edit', compact(
            'discussion',
            'categories',
            'classes'
        ));
    }
    
    /**
     * Update discussion.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:forum_categories,id',
            'class_id' => 'nullable|exists:school_classes,id',
            'tags' => 'nullable|string',
            'is_pinned' => 'boolean',
            'is_anonymous' => 'boolean'
        ]);
        
        // In real implementation, update in database
        return response()->json([
            'success' => true,
            'message' => 'Diskusi berhasil diperbarui',
            'redirect' => route('teacher.forum.show', $id)
        ]);
    }
    
    /**
     * Delete discussion.
     */
    public function destroy($id)
    {
        // In real implementation, delete from database
        return response()->json([
            'success' => true,
            'message' => 'Diskusi berhasil dihapus'
        ]);
    }
    
    /**
     * Add reply to discussion.
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
            'is_anonymous' => 'boolean'
        ]);
        
        // In real implementation, save reply to database
        return response()->json([
            'success' => true,
            'message' => 'Balasan berhasil ditambahkan',
            'reply' => (object) [
                'id' => rand(1000, 9999),
                'content' => $request->content,
                'author' => Auth::user()->name,
                'author_avatar' => 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=13315c&color=fff',
                'created_at' => now(),
                'is_anonymous' => $request->is_anonymous ?? false
            ]
        ]);
    }
    
    /**
     * Like/unlike discussion.
     */
    public function like($id)
    {
        // In real implementation, toggle like in database
        return response()->json([
            'success' => true,
            'liked' => true,
            'likes_count' => rand(5, 50)
        ]);
    }
    
    /**
     * Pin/unpin discussion.
     */
    public function pin($id)
    {
        // In real implementation, toggle pin in database
        return response()->json([
            'success' => true,
            'pinned' => true,
            'message' => 'Diskusi berhasil dipasang'
        ]);
    }
    
    /**
     * Search discussions.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('category');
        $sort = $request->get('sort', 'latest');
        
        // Get search results
        $results = $this->getSearchResults($query, $category, $sort);
        
        return view('teacher.forum.search', compact(
            'results',
            'query',
            'category',
            'sort'
        ));
    }
    
    /**
     * Get forum categories.
     */
    private function getForumCategories()
    {
        return collect([
            (object) [
                'id' => 1,
                'name' => 'Pembelajaran',
                'description' => 'Diskusi tentang metode pembelajaran dan kurikulum',
                'discussion_count' => 25,
                'color' => 'blue',
                'icon' => 'book'
            ],
            (object) [
                'id' => 2,
                'name' => 'Penilaian',
                'description' => 'Berbagi pengalaman dan tips penilaian siswa',
                'discussion_count' => 18,
                'color' => 'green',
                'icon' => 'chart'
            ],
            (object) [
                'id' => 3,
                'name' => 'Teknologi Pendidikan',
                'description' => 'Diskusi tentang teknologi dalam pendidikan',
                'discussion_count' => 12,
                'color' => 'purple',
                'icon' => 'computer'
            ],
            (object) [
                'id' => 4,
                'name' => 'Manajemen Kelas',
                'description' => 'Tips dan trik mengelola kelas yang efektif',
                'discussion_count' => 15,
                'color' => 'orange',
                'icon' => 'users'
            ],
            (object) [
                'id' => 5,
                'name' => 'Pengembangan Profesi',
                'description' => 'Diskusi tentang pengembangan karir guru',
                'discussion_count' => 8,
                'color' => 'red',
                'icon' => 'star'
            ]
        ]);
    }
    
    /**
     * Get recent discussions.
     */
    private function getRecentDiscussions($teacher)
    {
        return collect([
            (object) [
                'id' => 1,
                'title' => 'Metode Pembelajaran Daring yang Efektif',
                'content' => 'Bagaimana cara membuat pembelajaran daring lebih interaktif dan menarik?',
                'author' => 'Bu Sari',
                'author_avatar' => 'https://ui-avatars.com/api/?name=Bu+Sari&background=random',
                'category' => 'Pembelajaran',
                'category_color' => 'blue',
                'replies_count' => 12,
                'likes_count' => 8,
                'views_count' => 45,
                'is_pinned' => true,
                'created_at' => now()->subHours(2),
                'last_reply_at' => now()->subMinutes(30)
            ],
            (object) [
                'id' => 2,
                'title' => 'Tips Menilai Kreativitas Siswa',
                'content' => 'Apa saja indikator yang bisa digunakan untuk menilai kreativitas siswa?',
                'author' => 'Pak Budi',
                'author_avatar' => 'https://ui-avatars.com/api/?name=Pak+Budi&background=random',
                'category' => 'Penilaian',
                'category_color' => 'green',
                'replies_count' => 7,
                'likes_count' => 5,
                'views_count' => 32,
                'is_pinned' => false,
                'created_at' => now()->subHours(5),
                'last_reply_at' => now()->subHours(1)
            ],
            (object) [
                'id' => 3,
                'title' => 'Aplikasi Quiz Online Terbaik',
                'content' => 'Rekomendasi aplikasi untuk membuat quiz online yang menarik',
                'author' => 'Bu Lisa',
                'author_avatar' => 'https://ui-avatars.com/api/?name=Bu+Lisa&background=random',
                'category' => 'Teknologi Pendidikan',
                'category_color' => 'purple',
                'replies_count' => 15,
                'likes_count' => 12,
                'views_count' => 67,
                'is_pinned' => false,
                'created_at' => now()->subDays(1),
                'last_reply_at' => now()->subHours(3)
            ]
        ]);
    }
    
    /**
     * Get my discussions.
     */
    private function getMyDiscussions($teacher)
    {
        return collect([
            (object) [
                'id' => 4,
                'title' => 'Strategi Mengatasi Siswa yang Malas',
                'content' => 'Bagaimana cara memotivasi siswa yang terlihat malas belajar?',
                'category' => 'Manajemen Kelas',
                'category_color' => 'orange',
                'replies_count' => 9,
                'likes_count' => 6,
                'views_count' => 28,
                'is_pinned' => false,
                'created_at' => now()->subDays(2),
                'last_reply_at' => now()->subHours(4)
            ],
            (object) [
                'id' => 5,
                'title' => 'Workshop Pengembangan Diri',
                'content' => 'Info workshop untuk pengembangan profesional guru',
                'category' => 'Pengembangan Profesi',
                'category_color' => 'red',
                'replies_count' => 3,
                'likes_count' => 2,
                'views_count' => 15,
                'is_pinned' => false,
                'created_at' => now()->subDays(3),
                'last_reply_at' => now()->subDays(1)
            ]
        ]);
    }
    
    /**
     * Get forum statistics.
     */
    private function getForumStats($teacher)
    {
        return [
            'total_discussions' => 156,
            'my_discussions' => 12,
            'total_replies' => 423,
            'my_replies' => 45,
            'total_likes' => 234,
            'my_likes' => 18,
            'categories_count' => 5,
            'active_users' => 28
        ];
    }
    
    /**
     * Get trending topics.
     */
    private function getTrendingTopics()
    {
        return collect([
            (object) ['name' => 'Pembelajaran Daring', 'count' => 15],
            (object) ['name' => 'Penilaian Otentik', 'count' => 12],
            (object) ['name' => 'Teknologi Pendidikan', 'count' => 10],
            (object) ['name' => 'Manajemen Kelas', 'count' => 8],
            (object) ['name' => 'Kreativitas Siswa', 'count' => 6]
        ]);
    }
    
    /**
     * Get category details.
     */
    private function getCategoryDetails($categoryId)
    {
        return (object) [
            'id' => $categoryId,
            'name' => 'Pembelajaran',
            'description' => 'Diskusi tentang metode pembelajaran dan kurikulum',
            'discussion_count' => 25,
            'color' => 'blue',
            'icon' => 'book'
        ];
    }
    
    /**
     * Get discussions in category.
     */
    private function getCategoryDiscussions($categoryId)
    {
        return collect([
            (object) [
                'id' => 1,
                'title' => 'Metode Pembelajaran Daring yang Efektif',
                'content' => 'Bagaimana cara membuat pembelajaran daring lebih interaktif dan menarik?',
                'author' => 'Bu Sari',
                'author_avatar' => 'https://ui-avatars.com/api/?name=Bu+Sari&background=random',
                'replies_count' => 12,
                'likes_count' => 8,
                'views_count' => 45,
                'is_pinned' => true,
                'created_at' => now()->subHours(2),
                'last_reply_at' => now()->subMinutes(30)
            ],
            (object) [
                'id' => 2,
                'title' => 'Kurikulum Merdeka: Implementasi di Kelas',
                'content' => 'Pengalaman implementasi kurikulum merdeka di kelas VII',
                'author' => 'Pak Andi',
                'author_avatar' => 'https://ui-avatars.com/api/?name=Pak+Andi&background=random',
                'replies_count' => 8,
                'likes_count' => 6,
                'views_count' => 38,
                'is_pinned' => false,
                'created_at' => now()->subHours(6),
                'last_reply_at' => now()->subHours(2)
            ]
        ]);
    }
    
    /**
     * Get category statistics.
     */
    private function getCategoryStats($categoryId)
    {
        return [
            'total_discussions' => 25,
            'total_replies' => 156,
            'total_views' => 1234,
            'active_users' => 12
        ];
    }
    
    /**
     * Get discussion details.
     */
    private function getDiscussionDetails($id)
    {
        return (object) [
            'id' => $id,
            'title' => 'Metode Pembelajaran Daring yang Efektif',
            'content' => 'Bagaimana cara membuat pembelajaran daring lebih interaktif dan menarik? Saya sudah mencoba beberapa platform seperti Zoom dan Google Meet, tapi masih merasa kurang optimal untuk pembelajaran yang interaktif. Apakah ada tips atau tools lain yang bisa digunakan?',
            'author' => 'Bu Sari',
            'author_avatar' => 'https://ui-avatars.com/api/?name=Bu+Sari&background=random',
            'category' => 'Pembelajaran',
            'category_color' => 'blue',
            'tags' => ['pembelajaran daring', 'teknologi', 'interaktif'],
            'replies_count' => 12,
            'likes_count' => 8,
            'views_count' => 45,
            'is_pinned' => true,
            'is_anonymous' => false,
            'created_at' => now()->subHours(2),
            'updated_at' => now()->subMinutes(30)
        ];
    }
    
    /**
     * Get discussion replies.
     */
    private function getDiscussionReplies($id)
    {
        return collect([
            (object) [
                'id' => 1,
                'content' => 'Saya menggunakan Kahoot dan Mentimeter untuk membuat pembelajaran lebih interaktif. Siswa sangat antusias dengan quiz dan polling real-time.',
                'author' => 'Pak Budi',
                'author_avatar' => 'https://ui-avatars.com/api/?name=Pak+Budi&background=random',
                'is_anonymous' => false,
                'likes_count' => 3,
                'created_at' => now()->subHours(1),
                'replies' => [
                    (object) [
                        'id' => 1,
                        'content' => 'Setuju! Kahoot memang sangat membantu untuk engagement siswa.',
                        'author' => 'Bu Lisa',
                        'author_avatar' => 'https://ui-avatars.com/api/?name=Bu+Lisa&background=random',
                        'created_at' => now()->subMinutes(45)
                    ]
                ]
            ],
            (object) [
                'id' => 2,
                'content' => 'Selain platform video, saya juga menggunakan Google Classroom untuk assignment dan feedback. Siswa bisa submit tugas dan mendapat feedback langsung.',
                'author' => 'Bu Ani',
                'author_avatar' => 'https://ui-avatars.com/api/?name=Bu+Ani&background=random',
                'is_anonymous' => false,
                'likes_count' => 2,
                'created_at' => now()->subMinutes(30),
                'replies' => []
            ]
        ]);
    }
    
    /**
     * Get related discussions.
     */
    private function getRelatedDiscussions($categoryId)
    {
        return collect([
            (object) [
                'id' => 3,
                'title' => 'Tips Menggunakan Google Classroom',
                'content' => 'Panduan lengkap menggunakan Google Classroom untuk pembelajaran daring',
                'author' => 'Pak Andi',
                'replies_count' => 5,
                'views_count' => 23,
                'created_at' => now()->subDays(1)
            ],
            (object) [
                'id' => 4,
                'title' => 'Platform Video Conference Terbaik',
                'content' => 'Perbandingan Zoom, Google Meet, dan Microsoft Teams',
                'author' => 'Bu Maria',
                'replies_count' => 8,
                'views_count' => 34,
                'created_at' => now()->subDays(2)
            ]
        ]);
    }
    
    /**
     * Get teacher classes.
     */
    private function getTeacherClasses($teacher)
    {
        return collect([
            (object) ['id' => 1, 'name' => 'VII A'],
            (object) ['id' => 2, 'name' => 'VII B'],
            (object) ['id' => 3, 'name' => 'VIII A']
        ]);
    }
    
    /**
     * Get search results.
     */
    private function getSearchResults($query, $category, $sort)
    {
        return collect([
            (object) [
                'id' => 1,
                'title' => 'Metode Pembelajaran Daring yang Efektif',
                'content' => 'Bagaimana cara membuat pembelajaran daring lebih interaktif...',
                'author' => 'Bu Sari',
                'category' => 'Pembelajaran',
                'replies_count' => 12,
                'likes_count' => 8,
                'created_at' => now()->subHours(2)
            ]
        ]);
    }
}

