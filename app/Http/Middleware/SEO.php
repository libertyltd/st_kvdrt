<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

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
        $SEO = \App\SEO::where(['original_url'=>$path, 'status'=>1])->first();
        if (!$SEO) {
            $SEO = \App\SEO::where(['alias_url'=>$path, 'status'=>1])->first();
        }



        if ($SEO) {
            \App\SEO::saveCurrentSEO($SEO);

            if (($SEO->original_url === $path) && ($SEO->alias_url != '')) {
                return redirect($SEO->alias_url, 301);
            }
        }

        return $next($request);
    }
}
