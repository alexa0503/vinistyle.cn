<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = \App\ItemType::paginate(20);
        return view('admin/type/index', ['rows'=>$rows]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/type/create');
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
            'title' => 'required|max:60',
            'intro' => 'required',
        ]);
        $row = new \App\ItemType;
        $row->name = trim($request->input('name'));
        $row->title = trim($request->input('title'));
        $row->intro = trim($request->input('intro'));
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
        $row = \App\ItemType::find($id);
        return view('admin/type/edit', ['row'=>$row]);
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
            'title' => 'required|max:60',
            'intro' => 'required',
        ]);
        $row = \App\ItemType::find($id);
        $row->name = trim($request->input('name'));
        $row->title = trim($request->input('title'));
        $row->intro = trim($request->input('intro'));
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
        $count = \App\Item::where('type_id')->count();
        if($count > 0){
            return ['ret'=>1001, 'msg'=>'该分类下含有产品,无法删除'];
        }
        $row = \App\ItemType::findOrFail($id);
        $row->delete();
        return ['ret'=>0];
    }
}
