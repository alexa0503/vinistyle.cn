<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $key = 'aW8PZkNZGHoNzJGR';
    public function handle($request, Closure $next)
    {
        if( null == $request->get('timestamp') || $this->key.$request->get('timestamp') != $request->get('sign')){
            return Response(json_encode(['flag'=>-1, 'msg'=>'sign invalid']),500);
        }
        return $next($request);
    }
}
