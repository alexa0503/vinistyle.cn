<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
class WechatAuthMiddleware
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
        $request->session()->set('wechat.redirect_uri', $request->getUri());
        if(env('APP_ENV') == 'local'){
            $wechat_user = App\wechatUser::find(1);
            Session::set('wechat.openid',$wechat_user->open_id);
            Session::set('wechat.id',$wechat_user->id);
            Session::set('wechat.nickname', json_decode($wechat_user->nick_name));
            Session::set('wechat.headimg', $wechat_user->head_img);
        }
        if( null == $request->session()->get('wechat.id') ){
            return redirect('/wechat/auth');
        }
        return $next($request);
    }
}
