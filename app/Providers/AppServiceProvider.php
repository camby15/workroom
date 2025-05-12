<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Load custom helper files
        foreach (glob(app_path('Helpers') . '/*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); 
        Paginator::useBootstrap();
        // Blade directive for currency formatting
        Blade::directive('currency', fn($expr) => "<?php echo currency($expr); ?>");
    }
}
