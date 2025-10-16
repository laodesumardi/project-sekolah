<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\PerformanceHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OptimizePerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'performance:optimize 
                            {--clear-cache : Clear all caches}
                            {--warm-cache : Warm up caches}
                            {--optimize-db : Optimize database tables}
                            {--analyze : Analyze performance metrics}
                            {--all : Run all optimizations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize website performance by clearing caches, warming caches, and optimizing database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting Performance Optimization...');
        
        if ($this->option('all') || $this->option('clear-cache')) {
            $this->clearCaches();
        }
        
        if ($this->option('all') || $this->option('warm-cache')) {
            $this->warmCaches();
        }
        
        if ($this->option('all') || $this->option('optimize-db')) {
            $this->optimizeDatabase();
        }
        
        if ($this->option('all') || $this->option('analyze')) {
            $this->analyzePerformance();
        }
        
        $this->info('✅ Performance optimization completed!');
    }

    /**
     * Clear all caches
     */
    private function clearCaches()
    {
        $this->info('🧹 Clearing caches...');
        
        PerformanceHelper::clearAllCaches();
        
        // Clear Laravel caches
        $this->call('cache:clear');
        $this->call('view:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        
        $this->info('✅ Caches cleared successfully');
    }

    /**
     * Warm up caches
     */
    private function warmCaches()
    {
        $this->info('🔥 Warming up caches...');
        
        PerformanceHelper::warmUpCaches();
        
        $this->info('✅ Caches warmed up successfully');
    }

    /**
     * Optimize database
     */
    private function optimizeDatabase()
    {
        $this->info('🗄️ Optimizing database...');
        
        PerformanceHelper::optimizeDatabase();
        
        $this->info('✅ Database optimized successfully');
    }

    /**
     * Analyze performance
     */
    private function analyzePerformance()
    {
        $this->info('📊 Analyzing performance...');
        
        $summary = PerformanceHelper::getPerformanceSummary();
        
        $this->table(
            ['Metric', 'Value'],
            [
                ['Timestamp', $summary['timestamp']],
                ['Cache Status', $summary['cache_status']],
                ['Database Optimized', $summary['database_optimized'] ? 'Yes' : 'No'],
            ]
        );
        
        if (!empty($summary['recommendations'])) {
            $this->warn('⚠️ Performance Recommendations:');
            foreach ($summary['recommendations'] as $recommendation) {
                $this->line("  • {$recommendation['message']} ({$recommendation['priority']} priority)");
            }
        } else {
            $this->info('✅ No performance issues detected');
        }
    }
}

