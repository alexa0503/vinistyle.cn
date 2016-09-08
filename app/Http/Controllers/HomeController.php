<?php

namespace App\Http\Controllers;
use App;
use Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('wechat.auth');
    }
    public function index()
    {
        return view('index');
    }
    public function save()
    {

    }
    public function richList()
    {
        $rich_list = App\RichList::where('user_id', Session::get('wechat.id'))->orderBy('created_at', 'DESC')->first();
        $wealth = rand(2401,6400);
        if( null == $rich_list){
            $scale = 0;
        }
        else{
            $scale = sprintf('%.2f',$wealth/$rich_list->wealth - 1);
        }
        $name = Session::get('wechat.nickname');
        $list = [
            ['name'=>'比尔', 'wealth'=>'5200', 'scale'=>'-0.06', 'from'=>'投资', 'location'=>'美国', 'isUser'=>false],
            ['name'=>'沃伦', 'wealth'=>'4500', 'scale'=>'-0.11', 'from'=>'投资', 'location'=>'美国', 'isUser'=>false],
            ['name'=>'阿曼西奥', 'wealth'=>'4200', 'scale'=>'0.16', 'from'=>'投资', 'location'=>'美国', 'isUser'=>false],
            ['name'=>'杰夫', 'wealth'=>'3500', 'scale'=>'0.83', 'from'=>'时装', 'location'=>'西班牙', 'isUser'=>false],
            ['name'=>'埃卢', 'wealth'=>'3300', 'scale'=>'-0.40', 'from'=>'电商', 'location'=>'美国', 'isUser'=>false],
            ['name'=>'马克', 'wealth'=>'3100', 'scale'=>'0.07', 'from'=>'通讯', 'location'=>'墨西哥', 'isUser'=>false],
            ['name'=>'拉里', 'wealth'=>'3000', 'scale'=>'-0.15', 'from'=>'社交', 'location'=>'美国', 'isUser'=>false],
            ['name'=>'大卫', 'wealth'=>'2700', 'scale'=>'-0.22', 'from'=>'软件', 'location'=>'美国', 'isUser'=>false],
            ['name'=>'查尔斯', 'wealth'=>'2500', 'scale'=>'0.22', 'from'=>'能源', 'location'=>'美国', 'isUser'=>false],
            ['name'=>'伯纳德', 'wealth'=>'2400', 'scale'=>'-0.76', 'from'=>'时装', 'location'=>'法国', 'isUser'=>false]
        ];
        $_list = [];
        $n = 0;
        foreach($list as $k=>$v){
            if($wealth > $v['wealth']){
                $n = $k;
                break;
            }
        }
        for($i = 0; $i < 10; $i++){
            if($i < $n){
                $_list[$i] = $list[$i];
            }
            elseif($i == $n){
                $_list[$i] = ['name'=>$name, 'wealth'=>$wealth, 'scale'=>$scale, 'from'=>'理财', 'location'=>'中国', 'isUser'=>true];
            }
            else{
                $_list[$i] = $list[$i-1];
            }
        }
        $rich_list = new App\RichList();
        $rich_list->wealth = $wealth;
        $rich_list->user_id = Session::get('wechat.id');
        $rich_list->save();
        sleep(1);

        return view('list', ['list' => $_list]);
    }
    public function lottery()
    {
        $prize = rand(0,4);
        return ['prize'=>$prize, 'ret'=>0];
    }
}
