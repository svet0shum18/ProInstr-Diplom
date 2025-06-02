<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ToolType;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $toolTypes = ToolType::withCount('products')
                          ->orderBy('name')
                          ->get();
            $view->with('toolTypes', $toolTypes);
        });
    }
}
