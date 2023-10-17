<?php

namespace App\Providers;

use App\Facades\CoreHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class PluginRouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->routes(function () {
            $plugins = CoreHelpers::getActivePlugins();
            foreach ($plugins as $plugin) {
                $this->rateLimit($plugin);

                Route::middleware('api')
                    ->prefix('api')
                    ->group(base_path('plugins/'.$plugin->location . '/routes/api.php'));

                Route::middleware('web')
                    ->prefix('admin')
                    ->group(base_path('plugins/'.$plugin->location . '/routes/web.php'));
            }
        });
    }

    /**
     * Custom rate limiting
     */
    public function rateLimit($plugin)
    {
        RateLimiter::for($plugin->location, function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
