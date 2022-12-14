<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;
use App\Http\Requests\TruckRequest;
use App\Models\Mark;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Truck  $model
     * @return \Illuminate\Http\Response
     */
    public function index(Truck $model)
    {
        //
        $trucks = $model->all();
        return view('trucks.index',compact('trucks')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $marks = Mark::all();
        return view('trucks.create',compact('marks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\TruckRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TruckRequest $request)
    {
        //
        $validatedData = $request->validate([
            'registration' => 'required|min:3',
            'model' => 'nullable',
            'mark_id' => 'nullable',
            'tare' => 'nullable',
        ]);
        
        $truck=Truck::create($validatedData);
        if ($request->ajax()) {
            $trucks = Truck::all()->pluck('registration', 'id');

            return response()->json([
                'selectedId'=>$truck->id,
                'trucks'=>$trucks
                 ]);
        } else {
            return redirect('/trucks')->with('message',__('Truck successfully created.'));
        }
        
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
        $truck = Truck::findOrFail($id);
        $marks = Mark::pluck('name', 'id');
        return view('trucks.edit', compact('truck','marks'));
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
            'registration' => 'required|min:3',
            'model' => 'nullable',
            'mark_id' => 'nullable',
            'tare' => 'nullable',
        ]);
        Truck::whereId($id)->update($validatedData);
        return redirect('/trucks')->with('message',__('Truck successfully updated.'));
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
        $truck = Truck::findOrFail($id);
        $truck->delete();
        return redirect('/trucks')->with('message',__('Truck successfully deleted.'));
    }
}
