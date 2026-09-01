<?php

namespace App\Providers;
use Carbon\Carbon;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('en');
         Paginator::useBootstrap();
        
        // Or customize default pagination view globally
        Paginator::defaultView('vendor.pagination.default');
        Paginator::defaultSimpleView('vendor.pagination.simple-default');
        
        Relation::morphMap([
            'staff' => 'App\Models\Staff',
            'driver' => 'App\Models\Driver',
 ]);
 if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
    }
}
