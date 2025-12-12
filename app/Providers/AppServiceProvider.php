<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Console\Commands\PreserveRefreshDatabase;
use App\Console\Commands\ClearArticles;

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
        // Use Bootstrap 5 compatible pagination views
        Paginator::useBootstrapFive();
        // Register artisan commands that are not in Kernel
        $this->commands([
            PreserveRefreshDatabase::class,
            ClearArticles::class,
        ]);
    }
}
