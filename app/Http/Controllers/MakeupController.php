<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MakeupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $makeups = \App\Makeup::all()->map(function($item, $key){
            $feature_id = count($item->features) > 0 ? $item->features[0]->id : null;
            $makeup = [
                'id'=>$item->id,
                'pre_img_url'=>$item->pre_img_url,
                'title'=>$item->title,
                'feature_id'=>$feature_id,
            ];
            return $makeup;
        });
        return \Response::json(['ret'=>0,'data'=>$makeups]);
        //return $list;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $makeup = \App\Makeup::find($id);

        $images = null;
        if( $makeup->images && count($makeup->images) > 0 ){
            $images = $makeup->images->map(function($item, $key){
                return [
                    'url'=>$item->url,
                    'title'=>$item->title,
                ];
            });
        }

        $feature_id = count($makeup->features) > 0 ? $makeup->features[0]->id : null;

        $items = null;
        if( $makeup->items && count($makeup->items) > 0 ){
            $items = $makeup->items->map(function($item, $key){
                return [
                    'id'=>$item->id,
                    'pre_img_url'=>$item->pre_img_url,
                    'name'=>$item->name,
                ];
            });
        }

        $data = [
            'id'=>$makeup->id,
            'title'=>$makeup->title,
            'sub_title'=>$makeup->sub_title,
            'desc'=>$makeup->desc,
            'application'=>$makeup->application,
            'images'=>$images,
            'feature_id'=>$feature_id,
            'items'=>$items,
        ];
        return ['ret'=>0, 'data'=>$data];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
