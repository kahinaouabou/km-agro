<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParcelCategory;
use App\Http\Requests\ParcelCategoryRequest;
use App\Models\Parcel;

class ParcelCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\ParcelCategory  $model
     * @return \Illuminate\View\View
     */
    public function index(ParcelCategory $model)
    {
        //
        $parcelCategories = $model->paginate(15);
        return view('parcelCategories.index',compact('parcelCategories')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('parcelCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ParcelCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParcelCategoryRequest $request)
    {
       $validatedData = $request->validate([
            'code' => 'required|min:3',
            'name' => 'required|min:3',
        ]);
        ParcelCategory::create($validatedData);
        return redirect('/parcelCategories')->with('message',__('Parcel category successfully created.'));
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
        
        $parcelCategory = ParcelCategory::findOrFail($id);
        return view('parcelCategories.edit', compact('parcelCategory'));
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
        ParcelCategory::whereId($id)->update($validatedData);
        return redirect('/parcelCategories')->with('message',__('Parcel category successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dependences =$this->verifyDependences($id);
        if(!$dependences){
            $parcelCategory = ParcelCategory::findOrFail($id);
            $parcelCategory->delete();
            return redirect('/parcelCategories')->with('message',__('Parcel category successfully deleted.'));
        }else {
            return redirect('/parcelCategories')->with('error',__("Parcel category can't be deleted. Remove dependencies"));
        }
        
    }
    /**
     * @param  int  $blockId
     *
     */ 
    public function verifyDependences($parcelCategoryId) {
           $exist =  Parcel::checkIfParcelExist($parcelCategoryId);
           return $exist;
    }
}
