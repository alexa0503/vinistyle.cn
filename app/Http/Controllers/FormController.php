<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class FormController extends Controller
{
    //
    public function store(Request $request)
    {
        $user_id = $request->input('uid');
        $count = \App\User::where('id', $user_id)->count();
        if( $count == 0){
            return ["flag"=>0, ,"msg"=>"数据格式有误"] ;
        }
        \App\Answer::find('user_id', $user_id)->delete();
        $data = json_encode($request->input('results'), true);
        foreach( $data as $k => $v){
            $input_data = [
                'user_id'=>$user_id,
                'question_id'=>$k,
                'value'=>$v,
            ];
            \App\Answer::firstOrCreate($input_data);
        }
        $items = \App\AnswerItem::where('user_id', $user_id)->get()->map(function($item){
            return [
                'name'=>$item->item->name,
                'id'=>$item->item->id,
                'pre_img_url'=>$item->item->pre_img_url,
                'type'=>[
                    'name'=>$item->type->name,
                    'sub_title'=>$item->type->title,
                    'id'=>$item->type->id,
                ],
            ];
        });
        return ['flag'=>1, 'analysis'=>$items, 'msg'=>'提交成功'];
    }
    public function index()
    {
        $user_id = $request->input('uid');
        $count = \App\User::where('id', $user_id)->count();
        if( $count == 0){
            return ["flag"=>0, ,"msg"=>"数据格式有误"] ;
        }
        $items = \App\AnswerItem::where('user_id', $user_id)->get()->map(function($item){
            return [
                'name'=>$item->item->name,
                'id'=>$item->item->id,
                'pre_img_url'=>$item->item->pre_img_url,
                'type'=>[
                    'name'=>$item->type->name,
                    'sub_title'=>$item->type->title,
                    'id'=>$item->type->id,
                ],
            ];
        });
        return ['flag'=>1, 'analysis'=>$items, 'msg'=>'提交成功'];

    }
}
