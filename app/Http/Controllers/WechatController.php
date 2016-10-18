<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper;
use Carbon\Carbon;
use Log;

class WechatController extends Controller
{
    public function server()
    {
        Log::info('request arrived.');
        $server = \EasyWeChat::server();
        $server->setMessageHandler(function ($message) {
            if ($message->MsgType == 'text') {
                # code...
                switch ($message->Content) {
                    case '/::)':
                    case '/::P':
                    case '/::D':
                    case '/::B':
                    case '/:,@P':
                    case '/:,@-D':
                    case '/::>':
                    case '/:B-)':
                        return '1';
                        # code...
                        break;
                    case '/::(':
                    case '/::<':
                    case '/::T':
                    case '/::~':
                    case "/::'(":
                    case "/::'|":
                    case '/:@x':
                        return '2';
                        break;
                    case '/::@':
                    case '/::Q':
                    case '/::+':
                    case '/::8':
                    case '/:xx':
                    case '/::|':
                        return '3';
                        break;
                    case '/::$':
                    case '/::g':
                    case '/:?':
                    case '/:@>':
                    case '/:<@':
                    case '/:--b':
                    case '/:>-|':
                    case '/:P-(':
                        return '4';
                        break;
                    case '/:8-)':
                    case '/::X':
                    case '/:|-)':
                    case '/::-O':
                    case '/::Z':
                    case '/:,@x':
                    case '/:,@@':
                        return '5';
                        break;
                    case '/::O':
                    case '/:,@o':
                    case '/::d':
                    case '/::!':
                        return '6';
                        break;
                    case '/::L':
                    case '/:,@f':
                    case '/::-S':
                    case '/:!!!':
                    case '/:,@!':
                    case '/:8*':
                    case '/::,@':
                        return '7';
                        break;
                    default:
                        return '7';
                        # code...
                        break;
                }
                //$txt = new Text(['content'=>$message->Content]);
                //$message->Content
                return 'no result';
            }
        });
        Log::info('return response.');

        return $server->serve();
    }
    public function auth(Request $request)
    {
        if (null != $request->get('url')) {
            $request->session()->set('wechat.callback_url', urldecode($request->get('url')));
        } else {
            $request->session()->set('wechat.callback_url', null);
        }
        $app_id = env('WECHAT_APPID');
        $callback_url = $request->getUriForPath('/wechat/callback');
        $state = '';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$app_id.'&redirect_uri='.$callback_url."&response_type=code&scope=snsapi_userinfo&state=$state#wechat_redirect";

        return redirect($url);
    }
    public function callback(Request $request)
    {

        $app_id = env('WECHAT_APPID');
        $secret = env('WECHAT_SECRET');
        $code = $request->get('code');
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$app_id.'&secret='.$secret."&code=$code&grant_type=authorization_code";
        $data = Helper\HttpClient::get($url);
        $token = json_decode($data);
        if (isset($token->errcode) && $token->errcode != 0) {
            return view('errors/503', ['error_msg' => '获取用户信息失败~']);
        }

        $wechat_token = $token->access_token;
        $openid = $token->openid;

        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$wechat_token}&openid={$openid}";
        $data = Helper\HttpClient::get($url);
        $user_data = json_decode($data);
        if (isset($user_data) && isset($user_data->errcode)) {
            //echo $user_data->message;
            return view('errors/503', ['error_msg' => $user_data->message]);
            //return $user_data->message;
        } else {
            $wechat_user = \App\WechatUser::where('open_id', $openid);
            if ($wechat_user->count() > 0) {
                $wechat = $wechat_user->first();
                $wechat->updated_at = Carbon::now();
            } else {
                $wechat = new \App\WechatUser();
                $wechat->open_id = $openid;
                $wechat->created_at = Carbon::now();
                $wechat->ip_address = $request->getClientIp();
                $wechat->updated_at = null;
            }
            $wechat->gender = $user_data->sex;
            $wechat->head_img = $user_data->headimgurl;
            $wechat->nick_name = json_encode($user_data->nickname);
            $wechat->country = $user_data->country;
            $wechat->province = $user_data->province;
            $wechat->city = $user_data->city;
            //$wechat->options = $options;
            $wechat->save();
            $request->session()->set('wechat.id', $wechat->id);
            $request->session()->set('wechat.openid', $openid);
            $request->session()->set('wechat.nickname', json_decode($wechat->nick_name));
            $request->session()->set('wechat.headimg', $wechat->head_img);

            return redirect($request->session()->get('wechat.redirect_uri'));
        }
    }
}
