<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SEO
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
        $path = $request->path();

        $SEO = \App\SEO::where(['original_url'=>$path])->first();
        if (!$SEO) {
            $SEO = \App\SEO::where(['alias_url'=>$path])->first();
        }

        if ($SEO) {
            \App\SEO::saveCurrentSEO($SEO);
        }

        return $next($request);
    }
}
