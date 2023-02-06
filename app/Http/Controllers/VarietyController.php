<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variety;
use Illuminate\Http\Request;

class VarietyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Variety $model)
    {
        
        $varieties = $model->paginate(15);
        return view('varieties.index',compact('varieties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('varieties.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required',
            'name' => 'required|min:3'
        ]);
        
        Variety::create($validatedData);
       
        return redirect('/varieties')->with('message',__('Variety successfully created.'));
    
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
        $variety = Variety::findOrFail($id);
        $products = Product::pluck('name', 'id');
        return view('varieties.edit', compact('variety','products'));
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
            'product_id' => 'required',
            'name' => 'required|min:3',
        ]);
        
        Variety::whereId($id)->update($validatedData);
       
        return redirect('/varieties')->with('message',__('Variety successfully updated.'));
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
