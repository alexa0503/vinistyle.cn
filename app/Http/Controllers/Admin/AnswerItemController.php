<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnswerItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($question_id)
    {
        $question = \App\Question::find($question_id);
        $rows = \App\AnswerItem::where('question_id', $question_id)->paginate(20);
        return view('admin/answers/items/index', ['rows'=>$rows, 'question'=>$question]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($question_id)
    {
        $question = \App\Question::find($question_id);
        $items = \App\Item::all();
        return view('admin/answers/items/create', ['question'=>$question, 'items'=>$items]);
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
            'answer' => 'required|max:60',
            'question_id' => 'required|exists:questions,id',
            'item_id' => 'required|exists:items,id',
        ]);
        $data = [
            'answer' => trim($request->input('answer')),
            'question_id' => $request->input('question_id'),
            'item_id' => $request->input('item_id'),
        ];
        \App\AnswerItem::firstOrCreate($data);
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
    public function edit($question_id, $id)
    {
        $question = \App\Question::find($question_id);
        $row = \App\AnswerItem::find($id);
        return view('admin/answers/items/edit', ['question'=>$question, 'row'=>$row]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $question_id, $id)
    {
        $this->validate($request, [
            'answer' => 'required|max:60',
            'question_id' => 'required|exists:questions,id',
            'item_id' => 'required|exists:items,id',
        ]);
        $data = [
            'answer' => trim($request->input('answer')),
            'question_id' => $request->input('question_id'),
            'item_id' => $request->input('item_id'),
        ];
        \App\AnswerItem::where('id',$id)->update($data);
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
        //
    }
}
