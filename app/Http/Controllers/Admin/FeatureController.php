<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = \App\Feature::paginate(20);
        return view('admin/feature/index', ['rows'=>$features]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = \App\Item::all();
        return view('admin/feature/create',['items'=>$items]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
            'image' => 'required|mimes:jpeg,bmp,png,gif',
        ]);
        $image = '';
        if ($request->hasFile('image')) {
            if ($request->file('image')->getError() != 0) {
                return Response(['image' => $request->file('image')->getErrorMessage()], 422);
            }
            $file = $request->file('image');

            $entension = $file->getClientOriginalExtension();
            $file_name = uniqid().'.'.$entension;
            $path = 'uploads/'.date('Ymd').'/';
            $file->move(public_path($path), $file_name);
            $image = $path.$file_name;
        }

        $row = new \App\Feature();
        $row->name = trim($request->input('name'));
        $row->pre_img_path = $image;
        $row->type = $request->input('type');
        $row->profession = $request->input('profession');
        $row->intro = $request->input('intro');
        $row->content = $request->input('content');
        $row->save();

        $item_ids = $request->input('item_ids');
        if( !empty($item_ids) && is_array($item_ids) ){
            foreach( $item_ids as $id){
                $feature_item = new \App\FeatureItem();
                $feature_item->feature_id = $row->id;
                $feature_item->item_id = $id;
                $feature_item->save();
            }
        }
        return [];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = \App\Feature::find($id);
        $items = \App\Item::all();
        $item_ids = $row->items->map(function($item){
            return $item->id;
        })->toArray();
        return view('admin/feature/edit', [
            'row'=>$row,
            'items'=>$items,
            'item_ids'=>$item_ids
        ]);
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
        $this->validate($request, [
            'name' => 'required|max:60',
            'image' => 'mimes:jpeg,bmp,png,gif',
        ]);
        $row = \App\Feature::find($id);
        $image = $row->pre_img_path;
        if ($request->hasFile('image')) {
            if ($request->file('image')->getError() != 0) {
                return Response(['image' => $request->file('image')->getErrorMessage()], 422);
            }
            $file = $request->file('image');

            $entension = $file->getClientOriginalExtension();
            $file_name = uniqid().'.'.$entension;
            $path = 'uploads/'.date('Ymd').'/';
            $file->move(public_path($path), $file_name);
            $image = $path.$file_name;
        }

        $item_ids = $request->input('item_ids');
        \App\FeatureItem::where('feature_id', $row->id)->delete();
        if( !empty($item_ids) && is_array($item_ids) ){
            foreach( $item_ids as $id){
                $feature_item = new \App\FeatureItem();
                $feature_item->feature_id = $row->id;
                $feature_item->item_id = $id;
                $feature_item->save();
            }
        }

        $row->name = trim($request->input('name'));
        $row->pre_img_path = $image;
        $row->type = $request->input('type');
        $row->profession = $request->input('profession');
        $row->intro = $request->input('intro');
        $row->content = $request->input('content');
        $row->save();
        return [];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = \App\Feature::findOrFail($id);
        \App\FeatureMakeup::where('feature_id', $row->id)->delete();
        \App\FeatureItem::where('feature_id', $row->id)->delete();
        $row->delete();
        return ['ret'=>0];
    }
}
