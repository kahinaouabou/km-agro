<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PivotRequest;
use App\Models\Pivot;

class PivotController extends Controller
{

   /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Pivot  $model
     * @return \Illuminate\View\View
     */
    public function index(Pivot $model)
    {
        $pivots = $model->paginate(15);
        return view('pivots.index',compact('pivots'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pivots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * 
     * @param  \Illuminate\Http\PivotRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PivotRequest $request)
    {
       $validatedData = $request->validate([
            'delivery_bill_prefix' => 'required|min:1',
            'name' => 'required|min:1',
        ]);
        Pivot::create($validatedData);
        return redirect('/pivots')->with('message',__('Pivot successfully created.'));
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
        $pivot = Pivot::findOrFail($id);
        return view('pivots.edit', compact('pivot'));
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
            'delivery_bill_prefix' => 'required|min:1',
            'name' => 'required|min:1',
        ]);
        Pivot::whereId($id)->update($validatedData);
        return redirect('/pivots')->with('message',__('Pivot successfully updated.'));
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
            $pivot = Pivot::findOrFail($id);
            $pivot->delete();
            return redirect('/pivots')->with('message',__('Pivot successfully deleted.'));
        }else {
            return redirect('/pivots')->with('error',__("Pivot can't be deleted. Remove dependencies"));
        }
    }
}
