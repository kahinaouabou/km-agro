<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use Illuminate\Http\Request;
use App\Http\Requests\MarkRequest;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Mark  $model
     * @return \Illuminate\Http\Response
     */
    public function index(Mark $model)
    {
        //
        $marks = $model->paginate(15);
        return view('marks.index',compact('marks')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('marks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\MarkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarkRequest $request)
    {
        //
        $validatedData = $request->validate([
            'code' => 'required|min:3',
            'name' => 'required|min:3',
        ]);
        Mark::create($validatedData);
        return redirect('/marks')->with('message',__('Mark successfully created.'));
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
        //
        $mark = Mark::findOrFail($id);
        return view('marks.edit', compact('mark'));
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
        $validatedData = $request->validate([
            'code' => 'required|min:3',
            'name' => 'required|min:3',
        ]);
        Mark::whereId($id)->update($validatedData);
        return redirect('/marks')->with('message',__('Mark successfully updated.'));
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
        $dependences =$this->verifyDependences($id);
        if(!$dependences){
            $mark = Mark::findOrFail($id);
            $mark->delete();
            return redirect('/marks')->with('message',__('Mark successfully deleted.'));
        }else {
            return redirect('/marks')->with('error',__("Mark can't be deleted. Remove dependencies"));
        }
    }

     /**
     * @param  int  $markId
     *
     */ 
    public function verifyDependences($markId) {
        $exist =  Mark::checkIfTruckExist($markId);
        return $exist;
    }
}
