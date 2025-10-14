<?php

namespace App\Http\Middleware;

use App\Models\LoginSession;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackLoginSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $this->trackSession($request);
        }

        return $next($request);
    }

    /**
     * Track the current login session.
     */
    private function trackSession(Request $request)
    {
        $user = auth()->user();
        $sessionId = session()->getId();
        
        // Get user agent info
        $userAgent = $request->userAgent();
        $deviceType = $this->getDeviceType($userAgent);
        $browser = $this->getBrowser($userAgent);
        $os = $this->getOperatingSystem($userAgent);
        
        // Get location (optional)
        $location = $this->getLocation($request->ip());
        
        // Update or create session record
        LoginSession::updateOrCreate(
            [
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
            ],
            [
                'user_agent' => $userAgent,
                'device_type' => $deviceType,
                'browser' => $browser,
                'os' => $os,
                'location' => $location,
                'is_current' => true,
                'last_activity' => now(),
            ]
        );
        
        // Mark other sessions as not current
        LoginSession::where('user_id', $user->id)
            ->where('ip_address', '!=', $request->ip())
            ->update(['is_current' => false]);
    }
    
    /**
     * Get device type from user agent.
     */
    private function getDeviceType($userAgent)
    {
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            return 'mobile';
        } elseif (preg_match('/Tablet|iPad/', $userAgent)) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }
    
    /**
     * Get browser from user agent.
     */
    private function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            return 'Edge';
        } else {
            return 'Unknown';
        }
    }
    
    /**
     * Get operating system from user agent.
     */
    private function getOperatingSystem($userAgent)
    {
        if (strpos($userAgent, 'Windows') !== false) {
            return 'Windows';
        } elseif (strpos($userAgent, 'Mac') !== false) {
            return 'macOS';
        } elseif (strpos($userAgent, 'Linux') !== false) {
            return 'Linux';
        } elseif (strpos($userAgent, 'Android') !== false) {
            return 'Android';
        } elseif (strpos($userAgent, 'iOS') !== false) {
            return 'iOS';
        } else {
            return 'Unknown';
        }
    }
    
    /**
     * Get location from IP address (optional).
     */
    private function getLocation($ip)
    {
        // You can implement IP geolocation here
        // For now, return null
        return null;
    }
}