<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    public function boot(): void {
        // Share categories with all views for navbar dropdown
        View::composer('*', function ($view) {
            if (!app()->runningInConsole()) {
                $navCategories = Category::where('status', 'active')
                    ->whereNull('parent_id')
                    ->orderBy('sort_order')
                    ->take(8)
                    ->get();
                $view->with('navCategories', $navCategories);
            }
        });
    }
}