<?php

namespace App\Http\Controllers;
use App;
use App\Helper\HttpClient;
class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('web');
        //$this->middleware('api.auth');
    }
    //用户登录
    public function login(Request $request)
    {
        if( null == $request->input('mobile') ){
            return ['flag'=>0, 'errorCode'=>1, 'msg'=>'请完整填写相关信息'];
        }
        elseif( !preg_match('/^1\d{10}$/', $request->input('mobile')) ){
            return ['flag'=>0, 'errorCode'=>2, 'msg'=>'手机号码格式有误'];
        }
        $mobile = $request->input('mobile');
        $user = App\User::where('mobile', $mobile)->get();
        if( $user == null ){
            return ['flag'=>0, 'errorCode'=>3, 'msg'=>'请先注册'];
        }
        else{
            return ['flag'=>1, 'uid'=>$user->id, 'msg'=>'登录成功', 'state'=>$user->state];
        }
    }
    //用户注册
    public function register(Request $request)
    {
        $mobile = $request->input('mobile');
        $time = $request->input('time');
        $auth_code = $request->input('authCode');
        $url = 'http://wx.vinistyle.cn/api/sms/verifycode';
        if( $auth_code == null ){
            return [
                'flag' => 0,
                'errorCode' => 5,
                'msg' => '验证码错误',
            ];
        }
        $response = json_decode(HttpClient::post($url, [
            'mobile' => $mobile,
            'code' => $auth_code,
            'time' => $time,
        ]));
        if( $response == null || $response->error != 0 ){
            return [
                'flag' => 0,
                'errorCode' => 5,
                'msg' => '验证码错误',
            ];
        }
        $count = App\User::where('mobile', $mobile)->count();
        if( $count > 0){
            return [
                'flag' => 0,
                'errorCode' => 4,
                'msg' => '该手机号已被注册',
            ];
        }

        $user = new App\User();
        $user->mobile = $mobile;
        $user->state = 0;
        $user->save();
        return [
            'flag' => 1,
            'state' => 0,
            'uid' => $user->id,
            'msg' => '注册成功',
        ];
    }
    public function sms(Request $request)
    {
        if( null == $request->input('mobile') ){
            return ['flag'=>0, 'msg'=>'请填写手机号码'];
        }
        elseif( !preg_match('/^1\d{10}$/', $request->input('mobile')) ){
            return ['flag'=>0, 'msg'=>'手机号码格式有误'];
        }

        $url = 'http://wx.vinistyle.cn/api/sms/sendcode';
        $mobile = $request->input('mobile');
        $response = json_decode(HttpClient::post($url, ['mobile'=>$mobile]));
        if( $response == null || $response->error != 0){
            return ['flag'=>0,'msg'=>'短信发送失败'];
        }
        //\Session::set('codeTime', $response->data->timestamp);
        //发送验证码

        return [
            'flag'=> 1,
            'timestamp'=> $response->data->timestamp,
            'mibile'=> $mobile,
            'msg' => '短信发送成功',
        ];
    }
    public function show(Request $request,$mobile = null)
    {
        if( null == $mobile ){
            return ['flag'=>0, 'msg'=>'请填写手机号码'];
        }
        elseif( !preg_match('/^1\d{10}$/', $mobile) ){
            return ['flag'=>0, 'msg'=>'手机号码格式有误'];
        }
        $user = App\User::where('mobile', $mobile)->get();
        if( null == $user) {
            return ['flag'=>0, 'msg'=>'用户不存在'];
        }
        return [
            'flag' => 1,
            'msg' => '信息查询成功',
            'userInfo' => [
                'id' => $user->id,
                'name' => $user->name,
                'mobile' => $user->mobile,
                'birthday' => $user->birthday,
                'gender' => $user->gender,
                'email' => $user->email,
                'follow' => $user->follow,
            ]
        ];
    }
    public function update(Request $request,$id)
    {
        $count = App\User::where('id', $id)->count();
        if( $count == 0 ){
            return ['flag'=>0, 'msg'=>'用户不存在'];
        }
        $gender = $request->input('gender');
        $name = $request->input('name');
        $email = $request->input('email');
        $birthday = $request->input('birthday');
        $confirm_email = $request->input('confirmEmail');
        if( null == $gender ){
            return [
                'flag'=>0,
                'errorCode'=>1,
                'msg'=>'请完整填写信息',
            ];
        }
        elseif( null == $name ){
            return [
                'flag'=>0,
                'errorCode'=>1,
                'msg'=>'请完整填写信息',
            ];
        }
        elseif( null == $email ){
            return [
                'flag'=>0,
                'errorCode'=>1,
                'msg'=>'请完整填写信息',
            ];
        }
        elseif( null == $birthday ){
            return [
                'flag'=>0,
                'errorCode'=>1,
                'msg'=>'请完整填写信息',
            ];
        }
        elseif( $confirm_email != $email ){
            return [
                'flag'=>0,
                'errorCode'=>1,
                'msg'=>'确认邮箱地址有误',
            ];
        }

        try {
            $user = App\User::find($id);
            $user->gender = $gender;
            $user->name = $name;
            $user->email = $email;
            $user->birthday = $birthday;
            $user->save();
            return [
                'flag'=> 1,
                'msg'=> '更新成功',
            ];
        } catch (Exception $e) {
            return [
                'flag'=>0,
                'errorCode'=>1,
                'msg'=> $e->getMessage(),
            ];
        }
    }
}
