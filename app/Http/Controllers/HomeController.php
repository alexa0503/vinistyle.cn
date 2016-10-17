<?php

namespace App\Http\Controllers;
use EasyWeChat\Foundation\Application;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        //$this->middleware('wechat.auth');
    }
    public function index()
    {
        $app_id = env('WECHAT_APPID');
        $secret = env('WECHAT_SECRET');
        $options = [
            'debug' => true,
            'app_id' => env('WECHAT_APPID'),
            'secret' => env('WECHAT_SECRET'),
            'token' => env('WECHAT_TOKEN'),
            // 'aes_key' => null, // 可选
            'log' => [
                'level' => 'debug',
                //'file' => '/tmp/easywechat.log',
            ],
            //...
        ];

        $app = new Application($options);
        $response = $app->server->serve();

        return $response;
    }
}
