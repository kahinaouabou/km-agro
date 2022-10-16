<?php

namespace App\Http\Controllers;


use App\Enums\ThirdPartyEnum;
use App\Models\ThirdParty;
use App\Models\TransactionBox;
use App\Models\Bill;
use Illuminate\Http\Request;

class TransactionBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
   

    function index (Request $request) {
    
        $transactionBoxes = TransactionBox::where( function($query) use($request){
                         return $request->third_party_id ?
                                $query->from('transactionBoxes')->where('third_party_id',$request->third_party_id) : '';
                    })->where(function($query) use($request){
                        return $request->date_from ?
                               $query->from('transactionBoxes')->where('transaction_date','>=',$request->date_from) : '';
                   })->where(function($query) use($request){
                    return $request->date_to ?
                           $query->from('transactionBoxes')->where('transaction_date','<=',$request->date_to) : '';
               })
                    ->get();
         
        $selected_id = [];
        $selected_id['third_party_id'] = $request->third_party_id;
        $selected_id['date_from'] = $request->date_from;
        $selected_id['date_to'] = $request->date_to;
        $countReturnedBoxes = TransactionBox::where( function($query) use($request){
            return $request->third_party_id ?
                   $query->from('transactionBoxes')->where('third_party_id',$request->third_party_id) : '';
       })->where(function($query) use($request){
           return $request->date_from ?
                  $query->from('transactionBoxes')->where('transaction_date','>=',$request->date_from) : '';
      })->where(function($query) use($request){
       return $request->date_to ?
              $query->from('transactionBoxes')->where('transaction_date','<=',$request->date_to) : '';
  })->sum('number_boxes_returned');
        $countTakenBoxes = TransactionBox::where( function($query) use($request){
            return $request->third_party_id ?
                   $query->from('transactionBoxes')->where('third_party_id',$request->third_party_id) : '';
       })->where(function($query) use($request){
           return $request->date_from ?
                  $query->from('transactionBoxes')->where('transaction_date','>=',$request->date_from) : '';
      })->where(function($query) use($request){
       return $request->date_to ?
              $query->from('transactionBoxes')->where('transaction_date','<=',$request->date_to) : '';
  })->sum('number_boxes_taken');
        return view('transactionBoxes.index',
        compact('transactionBoxes','selected_id','countReturnedBoxes','countTakenBoxes'));
    
    }
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $thirdParties = ThirdParty:: getThirdPartiesByType(ThirdPartyEnum::Customer);
        return view('transactionBoxes.create',compact('thirdParties'));
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
            'transaction_date' => 'required',
            'third_party_id' => 'required',
            'number_boxes_returned'=>'required',
        ]);
        TransactionBox::create($validatedData);
        return redirect('/transactionBoxes')->with('message',__('Returned boxes successfully created.'));
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
        $transactionBox = TransactionBox::findOrFail($id);
        $thirdParties = ThirdParty::where('is_supplier',ThirdPartyEnum::Customer)->pluck('name', 'id');       
        return view('transactionBoxes.edit', compact('transactionBox','thirdParties'));
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
            'transaction_date' => 'required',
            'third_party_id' => 'required',
            'number_boxes_returned'=>'required',
            'number_boxes_taken'=>'required',
            'bill_id'=>'required',
        ]);
        TransactionBox::whereId($id)->update($validatedData);
        if(!empty($request->bill_id)){
            Bill::whereId($request->bill_id)->update(['number_boxes_returned'=>$request->number_boxes_returned]);
        }
        return redirect('/transactionBoxes')->with('message',__('Returned boxes successfully updated.'));
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
