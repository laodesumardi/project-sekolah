<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Get real-time dashboard data
     */
    public function getDashboardData(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        
        // Get dashboard data based on user role
        $dashboardData = $this->dashboardService->getDashboardStats($role, $user->id);
        
        return response()->json([
            'success' => true,
            'data' => $dashboardData,
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Get user statistics
     */
    public function getUserStats(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        
        $dashboardData = $this->dashboardService->getDashboardStats($role, $user->id);
        
        return response()->json([
            'success' => true,
            'users' => $dashboardData['users'],
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Get recent activities
     */
    public function getRecentActivities(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        
        $dashboardData = $this->dashboardService->getDashboardStats($role, $user->id);
        
        return response()->json([
            'success' => true,
            'activities' => $dashboardData['activities'],
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Get chart data
     */
    public function getChartData(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        
        $dashboardData = $this->dashboardService->getDashboardStats($role, $user->id);
        
        return response()->json([
            'success' => true,
            'charts' => $dashboardData['charts'],
            'timestamp' => now()->toISOString(),
        ]);
    }
}
