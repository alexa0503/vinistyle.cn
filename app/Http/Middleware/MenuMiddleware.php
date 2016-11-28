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
            $items = $menu->add('产品管理',['url'=>'#']);
            $items->add('查看', ['url'=>'admin/item']);
            $items->add('添加', ['url'=>'admin/item/create']);
            $item_types = $menu->add('产品分类管理',['url'=>'#']);
            $item_types->add('查看', ['url'=>'admin/type']);
            $item_types->add('添加', ['url'=>'admin/type/create']);
            $makeup = $menu->add('妆容管理',['url'=>'#']);
            $makeup->add('查看', ['url'=>'admin/makeup']);
            $makeup->add('添加', ['url'=>'admin/makeup/create']);
            $feature = $menu->add('达人专家',['url'=>'#']);
            $feature->add('查看', ['url'=>'admin/feature']);
            $feature->add('添加', ['url'=>'admin/feature/create']);
            //$menu->add('查看奖品',['url'=>'admin/prizes']);
            //$page->add('查看', 'page/view')->divide();
            //$menu->add('账户',['route'=>'admin_account']);
        });
        return $next($request);
    }
}
