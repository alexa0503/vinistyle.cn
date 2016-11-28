<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = \App\Item::paginate(20);
        return view('admin/item/index', ['rows'=>$items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = \App\ItemType::all();
        return view('admin/item/create', ['types'=>$types]);
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
            'price' => 'required|numeric',
            'type_id' => 'required|exists:item_types,id',
            //'image' => 'required|mimes:jpeg,bmp,png,gif',
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

        $row = new \App\Item();
        $row->name = trim($request->input('name'));
        $row->pre_img_path = $image;
        $row->color = $request->input('color');
        $row->specification = $request->input('specification');
        $row->content = $request->input('content');
        $row->price = $request->input('price');
        $row->type_id = $request->input('type_id');
        $row->save();
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
        $row = \App\Item::find($id);
        $types = \App\ItemType::all();
        return view('admin/item/edit', ['row'=>$row, 'types'=>$types]);
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
            'price' => 'required|numeric',
            'type_id' => 'required|exists:item_types,id',
            //'image' => 'required|mimes:jpeg,bmp,png,gif',
        ]);
        $row = \App\Item::find($id);
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

        $row->name = trim($request->input('name'));
        $row->pre_img_path = $image;
        $row->color = $request->input('color');
        $row->specification = $request->input('specification');
        $row->content = $request->input('content');
        $row->price = $request->input('price');
        $row->type_id = $request->input('type_id');
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
        $row = \App\Item::findOrFail($id);
        $row->delete();
        return ['ret'=>0];
    }
}
