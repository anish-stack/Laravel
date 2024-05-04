<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter; // Add this line
use Illuminate\Cache\RateLimiting\Limit; 

use Illuminate\Http\Request;

class RouteServiceProvider extends ServiceProvider
{
    // protected $namespace = 'App\Http\Controllers';

    public const HOME = '/home';

    public function boot()
    {
        $this->configureRateLimiting();
// dd("hh");
        $this->routes(function () {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            // Route::prefix('api')
            //     ->middleware('api')
            //     ->namespace($this->namespace)
            //     ->group(base_path('routes/api.php'));
        });
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
