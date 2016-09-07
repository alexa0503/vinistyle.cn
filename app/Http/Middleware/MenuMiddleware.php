<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Menu;
class MenuMiddleware
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
        Menu::make('adminNavbar', function($menu){
            $menu->add('控制面板',['route'=>'admin_dashboard']);
            $menu->add('抽奖记录',['url'=>'admin/lotteries']);
            $menu->add('查看奖品',['url'=>'admin/prizes']);
            //$page->add('查看', 'page/view')->divide();
            //$menu->add('账户',['route'=>'admin_account']);
        });
        return $next($request);
    }
}
