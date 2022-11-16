<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ThirdPartyRequest;
use App\Models\ThirdParty;

class ThirdPartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param boolean $isSupplier
     * @return \Illuminate\Http\Response
     */
    public function index($isSupplier)
    {
        //
        $isSupplier = (int)$isSupplier;
        $thirdParties = ThirdParty::all()->where('is_supplier', $isSupplier);
        //and create a view which we return - note dot syntax to go into folder
        if($isSupplier==1)  {     
            $activePage= 'thirdParty/1';
            $titlePage = 'Suppliers';
            }else {
                 $activePage= 'thirdParty/0';
                 $titlePage =  'Customers' ;
                
        }
        return view('thirdParties.index',compact('thirdParties','isSupplier','activePage','titlePage'));
    }

   public function searchName(Request $request){
    
    $search = mb_strtolower(trim($request->name));
    
    $thirdParty = ThirdParty::whereRaw('LOWER(TRIM(`name`)) LIKE ? ',[$search])->get();
    
    return response()->json([
        'thirdParty'=>$thirdParty
         ]);
        
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($isSupplier)
    {
        //
        if($isSupplier==1)  {     
            $activePage= 'thirdParty/1';
            $titlePage = 'Add supplier';
            }else {
                 $activePage= 'thirdParty/0';
                 $titlePage =  'Add customer' ;
                
        }        
        $isSupplier = (int)$isSupplier;
        return view('thirdParties.create', compact('isSupplier','activePage','titlePage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ThirdPartyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThirdPartyRequest $request)
    {
        //
        $validatedData = $request->validate([
            'code' => 'nullable',
            'name' => 'required|min:3',
            'address' => 'nullable',
            'phone' => 'nullable',
            'is_supplier'=> 'required',
        ]);
        $isSupplier = (int)$request->is_supplier ;
        $thirdParty = ThirdParty::create($validatedData);
        if ($request->ajax()) {
            $thirdParties = ThirdParty::all()->pluck('name', 'id')->where('is_supplier','=',$isSupplier);

            return response()->json([
                'selectedId'=>$thirdParty->id,
                'thirdParties'=>$thirdParties
                 ]);
        }else {
            if($isSupplier== 1){
                return redirect('/thirdParty/1')->with('message',__('Supplier successfully created.'));
            }else {
                return redirect('/thirdParty/0')->with('message',__('Customer successfully created.'));
            }
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
     * @param  bool  $isSupplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $isSupplier)
    {
        //
        
        $thirdParty = ThirdParty::findOrFail($id);
        if($isSupplier==1)  {     
            $activePage= 'thirdParty/1';
            $titlePage = 'Edit supplier';
            }else {
                 $activePage= 'thirdParty/0';
                 $titlePage =  'Edit customer' ;
                
        }        
        $isSupplier = (int)$isSupplier;
        return view('thirdParties.edit', compact('thirdParty','isSupplier','activePage','titlePage'));
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
            'code' => 'nullable',
            'name' => 'required|min:3',
            'address' => 'nullable',
            'phone' => 'nullable',
            'is_supplier'=> 'required',
        ]);
        ThirdParty::whereId($id)->update($validatedData);
        $isSupplier = (int)$request->is_supplier ;
        if($isSupplier== 1){
            return redirect('/thirdParty/1')->with('message',__('Supplier successfully updated.'));
        }else {
            return redirect('/thirdParty/0')->with('message',__('Customer successfully updated.'));
        }
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
