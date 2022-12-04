<?php

namespace App\Http\Controllers;
use App\Models\Discharge;
use Illuminate\Http\Request;
use App\Models\Company;
use PDF;


class DischargeController extends Controller
{
    // function __construct()

    // {

    //      $this->middleware('permission:discharge-list|discharge-create|discharge-edit|
    //      discharge-delete', ['only' => ['index','show']]);

    //      $this->middleware('permission:discharge-create', ['only' => ['create','store']]);

    //      $this->middleware('permission:discharge-edit', ['only' => ['edit','update']]);

    //      $this->middleware('permission:discharge-delete', ['only' => ['destroy']]);

    // }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $discharges = Discharge:: orderBy("name","asc")->get(); ;
        return view('discharges.index',compact('discharges'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('discharges.create');
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
            'discharge_date' => 'required',
            'amount' => 'required',
            'quantity' => 'required',
        ]);
        //dd($validatedData);
        
        Discharge::create($validatedData);
        return redirect('/discharges')->with('message',__('Discharge successfully created.'));
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
        $discharge = Discharge::findOrFail($id);
        return view('discharges.edit', compact('discharge'));
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
            'name' => 'required|min:3',
            'discharge_date' => 'required',
            'amount' => 'required',
            'quantity' => 'required',
        ]);
        Discharge::whereId($id)->update($validatedData);
        return redirect('/discharges')->with('message',__('Discharge successfully updated.'));
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
        $discharge = Discharge::findOrFail($id);
        $discharge->delete();
        return redirect('/discharges')->with('message',__('Discharge successfully deleted.'));
        
    }
    public function print($id){
        $discharge = Discharge::findOrFail($id);
        $company = Company::first();
        $pdf = PDF::loadView('discharges.pdf.print', 
        compact('discharge','company'));
        return $pdf->stream('decharge'.date('d-m-Y').'.pdf');
    }
}
