<?php

namespace DevDojo\App\Http\Middleware;

use Closure;

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
        $config_map = array(
            'site.title' => 'app.name',
            'site.url' => 'app.url',
            'site.debug' => 'app.debug',

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
        
        return $next($request);
    }
}
