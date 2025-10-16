<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PerformanceHelper
{
    /**
     * Clear all performance-related caches
     */
    public static function clearAllCaches()
    {
        $cacheKeys = [
            'homepage_setting_active',
            'homepage_statistics',
            'homepage_latest_news',
            'homepage_featured_news',
            'admin_news_stats',
            'news_categories',
            'news_popular',
            'news_recent',
            'news_popular_tags',
            'extracurriculars_featured',
            'extracurriculars_categories',
            'galleries_featured',
            'about_facilities',
            'about_achievements',
            'about_statistics',
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }

        // Clear PPDB stats cache
        Cache::forget('ppdb_stats_1'); // Default academic year
        Cache::forget('ppdb_stats_2'); // Alternative academic year
    }

    /**
     * Clear cache when news is updated
     */
    public static function clearNewsCache()
    {
        Cache::forget('admin_news_stats');
        Cache::forget('homepage_latest_news');
        Cache::forget('homepage_featured_news');
        Cache::forget('news_categories');
        Cache::forget('news_popular');
        Cache::forget('news_recent');
        Cache::forget('news_popular_tags');
    }

    /**
     * Clear cache when homepage settings are updated
     */
    public static function clearHomepageCache()
    {
        Cache::forget('homepage_setting_active');
        Cache::forget('homepage_statistics');
    }

    /**
     * Clear cache when achievements are updated
     */
    public static function clearAchievementCache()
    {
        Cache::forget('homepage_statistics');
        Cache::forget('about_statistics');
        Cache::forget('about_achievements');
    }

    /**
     * Clear cache when extracurriculars are updated
     */
    public static function clearExtracurricularCache()
    {
        Cache::forget('extracurriculars_featured');
        Cache::forget('extracurriculars_categories');
    }

    /**
     * Clear cache when galleries are updated
     */
    public static function clearGalleryCache()
    {
        Cache::forget('galleries_featured');
    }

    /**
     * Clear cache when facilities are updated
     */
    public static function clearFacilityCache()
    {
        Cache::forget('about_facilities');
    }

    /**
     * Get database performance metrics
     */
    public static function getDatabaseMetrics()
    {
        $metrics = [];
        
        try {
            // Get query count
            $metrics['query_count'] = DB::getQueryLog();
            
            // Get slow queries
            $slowQueries = collect($metrics['query_count'])
                ->filter(function ($query) {
                    return $query['time'] > 100; // Queries taking more than 100ms
                })
                ->toArray();
            
            $metrics['slow_queries'] = $slowQueries;
            $metrics['slow_query_count'] = count($slowQueries);
            
            // Get cache hit rate
            $cacheStats = Cache::getStore()->getStats();
            $metrics['cache_hit_rate'] = $cacheStats['hits'] / ($cacheStats['hits'] + $cacheStats['misses']) * 100;
            
        } catch (\Exception $e) {
            $metrics['error'] = $e->getMessage();
        }
        
        return $metrics;
    }

    /**
     * Optimize database tables
     */
    public static function optimizeDatabase()
    {
        $tables = [
            'users', 'news', 'achievements', 'galleries', 'facilities',
            'extracurriculars', 'registrations', 'teachers', 'school_classes',
            'news_categories', 'tags', 'homepage_settings', 'about_page_settings'
        ];

        foreach ($tables as $table) {
            try {
                DB::statement("OPTIMIZE TABLE {$table}");
            } catch (\Exception $e) {
                // Table might not exist, continue
                continue;
            }
        }
    }

    /**
     * Get performance recommendations
     */
    public static function getPerformanceRecommendations()
    {
        $recommendations = [];
        
        // Check for missing indexes
        $missingIndexes = self::checkMissingIndexes();
        if (!empty($missingIndexes)) {
            $recommendations[] = [
                'type' => 'database',
                'priority' => 'high',
                'message' => 'Missing database indexes detected',
                'details' => $missingIndexes
            ];
        }
        
        // Check cache hit rate
        $cacheStats = Cache::getStore()->getStats();
        $hitRate = $cacheStats['hits'] / ($cacheStats['hits'] + $cacheStats['misses']) * 100;
        
        if ($hitRate < 80) {
            $recommendations[] = [
                'type' => 'caching',
                'priority' => 'medium',
                'message' => 'Low cache hit rate detected',
                'details' => "Current hit rate: {$hitRate}%. Consider increasing cache TTL."
            ];
        }
        
        // Check for N+1 queries
        $queryLog = DB::getQueryLog();
        $similarQueries = collect($queryLog)->groupBy('sql')->filter(function ($queries) {
            return count($queries) > 5;
        });
        
        if ($similarQueries->isNotEmpty()) {
            $recommendations[] = [
                'type' => 'queries',
                'priority' => 'high',
                'message' => 'Potential N+1 query problem detected',
                'details' => 'Consider using eager loading to reduce database queries.'
            ];
        }
        
        return $recommendations;
    }

    /**
     * Check for missing indexes
     */
    private static function checkMissingIndexes()
    {
        $missingIndexes = [];
        
        // Check common query patterns
        $commonQueries = [
            'users.role' => 'users',
            'news.published_at' => 'news',
            'news.category_id' => 'news',
            'achievements.is_published' => 'achievements',
            'galleries.is_published' => 'galleries',
            'facilities.is_available' => 'facilities'
        ];
        
        foreach ($commonQueries as $column => $table) {
            try {
                $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Column_name = ?", [explode('.', $column)[1]]);
                if (empty($indexes)) {
                    $missingIndexes[] = "Missing index on {$column}";
                }
            } catch (\Exception $e) {
                // Table or column might not exist
                continue;
            }
        }
        
        return $missingIndexes;
    }

    /**
     * Warm up caches
     */
    public static function warmUpCaches()
    {
        // Warm up homepage caches
        Cache::remember('homepage_setting_active', 3600, function () {
            return \App\Models\HomepageSetting::getActive();
        });
        
        Cache::remember('news_categories', 3600, function () {
            return \App\Models\NewsCategory::withCount('news')->get();
        });
        
        Cache::remember('extracurriculars_categories', 3600, function () {
            return \App\Models\Extracurricular::select('category', \DB::raw('count(*) as total'))
                ->active()
                ->groupBy('category')
                ->pluck('total', 'category');
        });
    }

    /**
     * Get performance summary
     */
    public static function getPerformanceSummary()
    {
        $summary = [
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'cache_status' => 'active',
            'database_optimized' => true,
            'recommendations' => self::getPerformanceRecommendations(),
            'metrics' => self::getDatabaseMetrics()
        ];
        
        return $summary;
    }
}

