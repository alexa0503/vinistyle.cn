<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MakeupController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $makeups = \App\Makeup::paginate(20);
        return view('admin/makeup/index', ['rows'=>$makeups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $features = \App\Feature::all();
        return view('admin/makeup/create', ['features'=>$features]);
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
            'title' => 'required|max:60',
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
        $thumb = [];
        if ($request->hasFile('thumb')) {
            foreach( $request->file('thumb') as $file ){
                if ($file->getError() != 0) {
                    return Response(['thumb[]' => $file->getErrorMessage()], 422);
                }
                $entension = $file->getClientOriginalExtension();
                $file_name = uniqid().'.'.$entension;
                $path = 'uploads/'.date('Ymd').'/';
                $file->move(public_path($path), $file_name);
                $thumb[] = $path.$file_name;
            }
        }
        DB::beginTransaction();
        try{
            $row = new \App\Makeup();
            $row->pre_img_path = $image;
            $row->title = trim($request->input('title'));
            $row->sub_title = trim($request->input('sub_title'));
            $row->application = $request->input('application');
            $row->pre_img_path = $image;
            $row->desc = $request->input('desc');
            $row->save();

            foreach( $thumb as $value){
                $image = new \App\MakeupImage();
                $image->title = trim($request->input('title'));
                $image->path = $value;
                $image->makeup_id = $row->id;
                $image->save();
            }

            $feature_ids = $request->input('feature_ids');
            if( !empty($feature_ids) && is_array($feature_ids) ){
                foreach( $feature_ids as $id){
                    $feature_makeup = new \App\FeatureMakeup();
                    $feature_makeup->makeup_id = $row->id;
                    $feature_makeup->feature_id = $id;
                    $feature_makeup->save();
                }
            }

            $item_ids = $request->input('item_ids');
            if( !empty($item_ids) && is_array($item_ids) ){
                foreach( $item_ids as $id){
                    $makeu_item = new \App\MakeupItem();
                    $makeu_item->makeup_id = $row->id;
                    $makeu_item->item_id = $id;
                    $makeu_item->save();
                }
            }
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return Response(['thumb[]' => $e->getMessage()], 422);
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
        $row = \App\Makeup::find($id);
        $feature_ids = $row->features->map(function($item){
            return $item->id;
        })->toArray();

        $item_ids = $row->items->map(function($item){
            return $item->id;
        })->toArray();
        $features = \App\Feature::all();
        $items = \App\Item::all();
        return view('admin/makeup/edit', [
            'row'=>$row,
            'features'=>$features,
            'items'=>$items,
            'feature_ids'=>$feature_ids,
            'item_ids'=>$item_ids,
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
            'title' => 'required|max:60',
            'image' => 'mimes:jpeg,bmp,png,gif',
        ]);
        $row = \App\Makeup::find($id);
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

        $thumb = [];
        if ($request->hasFile('thumb')) {
            foreach( $request->file('thumb') as $file ){
                if ($file->getError() != 0) {
                    return Response(['thumb[]' => $file->getErrorMessage()], 422);
                }
                $entension = $file->getClientOriginalExtension();
                $file_name = uniqid().'.'.$entension;
                $path = 'uploads/'.date('Ymd').'/';
                $file->move(public_path($path), $file_name);
                $thumb[] = $path.$file_name;
            }
        }
        DB::beginTransaction();
        try{
            $row->title = trim($request->input('title'));
            $row->sub_title = trim($request->input('sub_title'));
            $row->application = $request->input('application');
            $row->pre_img_path = $image;
            $row->desc = $request->input('desc');
            $row->save();
            if( !empty($thumb) ){
                \App\MakeupImage::where('makeup_id', $row->id)->delete();
                foreach( $thumb as $value){
                    $image = new \App\MakeupImage();
                    $image->title = trim($request->input('title'));
                    $image->path = $value;
                    $image->makeup_id = $row->id;
                    $image->save();
                }
            }

            $feature_ids = $request->input('feature_ids');
            \App\FeatureMakeup::where('makeup_id', $row->id)->delete();
            if( !empty($feature_ids) && is_array($feature_ids) ){
                foreach( $feature_ids as $id){
                    $feature_makeup = new \App\FeatureMakeup();
                    $feature_makeup->makeup_id = $row->id;
                    $feature_makeup->feature_id = $id;
                    $feature_makeup->save();
                }
            }

            $item_ids = $request->input('item_ids');
            \App\MakeupItem::where('makeup_id', $row->id)->delete();
            if( !empty($item_ids) && is_array($item_ids) ){
                foreach( $item_ids as $id){
                    $makeu_item = new \App\MakeupItem();
                    $makeu_item->makeup_id = $row->id;
                    $makeu_item->item_id = $id;
                    $makeu_item->save();
                }
            }

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return Response(['thumb[]' => $e->getMessage()], 422);
        }
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
        $row = \App\Makeup::findOrFail($id);
        \App\FeatureMakeup::where('makeup_id', $row->id)->delete();
        \App\MakeupImage::where('makeup_id', $row->id)->delete();
        $row->delete();
        return ['ret'=>0];
    }
}
