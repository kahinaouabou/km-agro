<?php

namespace App\Http\Controllers;
use App\Models\Parcel;
use App\Models\ParcelCategory;
use App\Models\ThirdParty;
use Illuminate\Http\Request;

class ParcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * 
     * @param  \App\Models\Parcel  $model
     * @return \Illuminate\Http\Response
     */
    public function index(Parcel $model)
    {
        //
        $parcels = $model->paginate(15);
        //dd($parcels);
        return view('parcels.index',compact('parcels')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $parcelCategries = ParcelCategory::all();
        $thirdParties = ThirdParty::all();
        return view('parcels.create', compact('parcelCategries','thirdParties'));
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
        $validatedData = $request->validate([
            'code' => 'required|min:3',
            'name' => 'required|min:3',
            'address' => 'required',
            'parcel_category_id'=>'int'
        ]);
        Parcel::create($validatedData);
        return redirect('/parcels')->with('message',__('Parcel successfully created.'));
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
        $parcel = Parcel::findOrFail($id);
        $parcelCategries = ParcelCategory::pluck('name', 'id');
        $thirdParties = ThirdParty::pluck('name', 'id');
        return view('parcels.edit', compact('parcel','parcelCategries','thirdParties'));
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
            'address' => 'required',
            'parcel_category_id'=>'int'
        ]);
        Parcel::whereId($id)->update($validatedData);
        return redirect('/parcels')->with('message',__('Parcel successfully updated.'));
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
