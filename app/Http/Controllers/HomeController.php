<?php

namespace App\Http\Controllers;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        //$this->middleware('wechat.auth');
    }
    public function index()
    {

        $server = \EasyWeChat::server();
        $server->setMessageHandler(function ($message) {
            return "您好！欢迎关注我!";
        });
        $response = $server->serve();

        return $response;
    }
}
