<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PerformanceMonitoring
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();
        
        // Enable query logging
        DB::enableQueryLog();
        
        $response = $next($request);
        
        $endTime = microtime(true);
        $endMemory = memory_get_usage();
        
        $executionTime = ($endTime - $startTime) * 1000; // Convert to milliseconds
        $memoryUsage = $endMemory - $startMemory;
        $queryCount = count(DB::getQueryLog());
        
        // Log performance metrics
        $this->logPerformanceMetrics($request, $executionTime, $memoryUsage, $queryCount);
        
        // Add performance headers
        $response->headers->set('X-Execution-Time', round($executionTime, 2) . 'ms');
        $response->headers->set('X-Memory-Usage', $this->formatBytes($memoryUsage));
        $response->headers->set('X-Query-Count', $queryCount);
        
        return $response;
    }

    /**
     * Log performance metrics
     */
    private function logPerformanceMetrics(Request $request, float $executionTime, int $memoryUsage, int $queryCount)
    {
        $metrics = [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'execution_time' => $executionTime,
            'memory_usage' => $memoryUsage,
            'query_count' => $queryCount,
            'timestamp' => now()->toISOString(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
        ];
        
        // Log slow requests
        if ($executionTime > 1000) { // More than 1 second
            Log::warning('Slow request detected', $metrics);
        }
        
        // Log high memory usage
        if ($memoryUsage > 50 * 1024 * 1024) { // More than 50MB
            Log::warning('High memory usage detected', $metrics);
        }
        
        // Log high query count
        if ($queryCount > 20) {
            Log::warning('High query count detected', $metrics);
        }
        
        // Store metrics in cache for analysis
        $this->storePerformanceMetrics($metrics);
    }

    /**
     * Store performance metrics in cache
     */
    private function storePerformanceMetrics(array $metrics)
    {
        $key = 'performance_metrics_' . date('Y-m-d-H');
        $existingMetrics = Cache::get($key, []);
        
        $existingMetrics[] = $metrics;
        
        // Keep only last 100 metrics per hour
        if (count($existingMetrics) > 100) {
            $existingMetrics = array_slice($existingMetrics, -100);
        }
        
        Cache::put($key, $existingMetrics, 3600); // Store for 1 hour
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}


