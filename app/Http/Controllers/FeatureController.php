<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function type()
    {
        $features = \App\Feature::groupBy('type')->select('type as title')->get();
        return $features;
    }
    public function index($title)
    {
        $features = \App\Feature::where('type', urldecode($title))->get();
        $data = $features->map(function($item){
            return [
                'id'=>$item->id,
                'type'=>$item->type,
                'pre_img_url'=>$item->pre_img_url,
                'author'=>$item->name,
                'author_tag'=>$item->profession,
                'content'=>$item->content,
                'intro'=>$item->intro,
            ];
        });
        return [
            'flag'=>1,
            'msg'=>'信息获取成功',
            'list'=>$data,
        ];
    }
}
