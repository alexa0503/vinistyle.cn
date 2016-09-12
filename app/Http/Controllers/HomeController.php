<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
    public function share(Request $request, $id)
    {
        return view('index',['id'=>$id]);
    }
    protected function reorder($data, $list = null)
    {
        if( $list == null ){
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
        }

        if( null == $data){
            return $list;
        }
        $_list = [];
        $n = 0;
        foreach($list as $k=>$v){
            if($data['wealth'] > $v['wealth']){
                $n = $k;
                break;
            }
        }
        for($i = 0; $i < 10; $i++){
            if($i < $n){
                $_list[$i] = $list[$i];
            }
            elseif($i == $n){
                $_list[$i] = ['name'=>$data['name'], 'wealth'=>$data['wealth'], 'scale'=>$data['scale'], 'from'=>'理财', 'location'=>'中国', 'isUser'=>true];
            }
            else{
                $_list[$i] = $list[$i-1];
            }
        }
        return $_list;
    }
    public function richList(Request $request, $id = null)
    {
        $rich_list = App\RichList::where('user_id', Session::get('wechat.id'))->orderBy('created_at', 'DESC')->first();

        if( null == $rich_list){
            $scale = 0;
            $wealth = 0;
            $name = Session::get('wechat.nickname');
        }
        else{
            $wealth = $rich_list->wealth;
            $scale = $rich_list->scale;
            $name = json_decode($rich_list->user->nick_name);
            //$scale = sprintf('%.2f',$wealth/$rich_list->wealth - 1);
        }

        $data = [
            'name' => $name,
            'wealth' => $wealth,
            'scale' => $scale
        ];

        $_list = $this->reorder($data);

        if( $id != null ){
            $rich_list = App\RichList::find($id);
            if(null == $rich_list){
                return ['ret'=>1001,'msg'=>''];
            }
            $data = [
                'name' => json_decode($rich_list->user->nick_name),
                'wealth' => $rich_list->wealth,
                'scale' => $rich_list->scale,
            ];
            $_list = $this->reorder($data, $_list);
        }

        return view('list', ['list' => $_list]);
    }
    public function richRefresh(Request $request, $id = null)
    {
        $wealth = rand(0,9) < 8 ? rand(2401,5200) : rand(5201,9999);
        $rich_list = App\RichList::where('user_id', Session::get('wechat.id'))->orderBy('created_at', 'DESC')->first();

        if( null == $rich_list){
            $scale = 0;
            $name = Session::get('wechat.nickname');
        }
        else{
            //$scale = $rich_list->scale;
            $name = json_decode($rich_list->user->nick_name);
            $scale = sprintf('%.2f',$wealth/$rich_list->wealth - 1);
        }

        $data = [
            'name' => $name,
            'wealth' => $wealth,
            'scale' => $scale
        ];

        $_list = $this->reorder($data);

        if( $id != null ){
            $rich_list = App\RichList::find($id);
            if(null == $rich_list){
                return ['ret'=>1001,'msg'=>''];
            }
            $data = [
                'name' => json_decode($rich_list->user->nick_name),
                'wealth' => $rich_list->wealth,
                'scale' => $rich_list->scale,
            ];
            $_list = $this->reorder($data, $_list);
        }

        $rich_list = new App\RichList();
        $rich_list->wealth = $wealth;
        $rich_list->scale = $scale;
        $rich_list->user_id = Session::get('wechat.id');
        $rich_list->save();
        $html = view('list', ['list' => $_list]);
        return ['ret'=>0,'html'=>$html->render(),'link'=>url('/share/'.$rich_list->id)];
    }
    public function lottery()
    {
        $prize = rand(1,4);
        return ['prize'=>$prize, 'ret'=>0];
    }
}
