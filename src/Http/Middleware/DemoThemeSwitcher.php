<?php

namespace DevDojo\App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Schema;

class DemoThemeSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(env('DB_DATABASE') && Schema::hasTable('settings')){
            if(setting('site.demo_mode', 0) || env('DEMO_MODE')){
                if(isset($request->theme) && $request->is('/')){
                    $theme = \VoyagerThemes\Models\Theme::where('folder', '=', $request->theme)->first();
                    if(isset($theme->id)){
                        return redirect('/')->withCookie('voyager_theme', $request->theme);
                    }
                }
            }
        }

        return $next($request);
    }

}
