<?php

namespace DevDojo\App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Schema;

class DynamicConfigs
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
            $config_map = array(
                'site.title' => 'app.name',
                'site.url' => 'app.url',

                'mail.driver' => 'mail.driver',
                'mail.host' => 'mail.host',
                'mail.port' => 'mail.port',
                'mail.username' => 'mail.username',
                'mail.password' => 'mail.password',
                'mail.encryption' => 'mail.encryption',
                'mail.mailgun_domain' => 'services.mailgun.domain',
                'mail.mailgun_secret' => 'services.mailgun.secret'
            );

            foreach($config_map as $key => $config){
                if(setting($key)){
                    config([$config => setting($key)]);
                }
            }

            // specific for Debug setting
            if(setting('site.debug')){
                config(['app.debug' => true]);
            } else {
                config(['app.debug' => false]);
            }
        }
        
        return $next($request);
    }
}
