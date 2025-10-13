<?php

namespace App\Providers;

use App\Models\HomepageSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share HomepageSetting data with all views
        View::composer('*', function ($view) {
            $homepageSetting = HomepageSetting::getActive();
            $view->with('homepageSetting', $homepageSetting);
        });
    }
}