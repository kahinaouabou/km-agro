<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentCategory;
use App\Http\Requests\PaymentCategoryRequest;
use App\Models\Payment;

class PaymentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\PaymentCategory  $model
     * @return \Illuminate\View\View
     */
    public function index(PaymentCategory $model)
    {
        //
        $paymentCategories = $model->paginate(15);
        return view('paymentCategories.index',compact('paymentCategories')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('paymentCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PaymentCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentCategoryRequest $request)
    {
       $validatedData = $request->validate([
            'name' => 'required|min:3',
        ]);
        PaymentCategory::create($validatedData);
        return redirect('/paymentCategories')->with('message',__('Payment category successfully created.'));
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
        
        $paymentCategory = PaymentCategory::findOrFail($id);
        return view('paymentCategories.edit', compact('paymentCategory'));
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
        ]);
        PaymentCategory::whereId($id)->update($validatedData);
        return redirect('/paymentCategories')->with('message',__('Payment category successfully updated.'));
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
            $paymentCategory = PaymentCategory::findOrFail($id);
            $paymentCategory->delete();
            return redirect('/paymentCategories')->with('message',__('Payment category successfully deleted.'));
        }else {
            return redirect('/paymentCategories')->with('error',__("Payment category can't be deleted. Remove dependencies"));
        }
        
    }
    /**
     * @param  int  $blockId
     *
     */ 
    public function verifyDependences($paymentCategoryId) {
           $exist =  Payment::checkIfPaymentExist($paymentCategoryId);
           return $exist;
    }
}
