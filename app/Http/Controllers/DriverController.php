<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\ThirdParty;
use App\Enums\BillTypeEnum;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $drivers = Driver:: orderBy("name","asc")->get(); 
        return view('drivers.index',compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subcontractors = ThirdParty:: getThirdPartiesByBillType(BillTypeEnum::DeliveryBill,'create');
        return view('drivers.create', compact('subcontractors'));
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
            'name' => 'required|min:3',
            'third_party_id' => 'required',
        ]);
        
        $driver = Driver::create($validatedData);
        if ($request->ajax()) {
            $drivers = Driver::all()->pluck('name', 'id');

            return response()->json([
                'selectedId'=>$driver->id,
                'drivers'=>$drivers
                 ]);
        } else {
            return redirect('/drivers')->with('message', __('Driver successfully created.'));
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
        $driver = Driver::findOrFail($id);
        $subcontractors = ThirdParty:: getThirdPartiesByBillType(BillTypeEnum::DeliveryBill,'edit');;
        return view('subcontractors.edit', compact('block','subcontractors'));
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
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'third_party_id' => 'required',
        ]);
       Driver::whereId($id)->update($validatedData);
       
            return redirect('/drivers')->with('message',__('Driver successfully updated.'));
        
        
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
