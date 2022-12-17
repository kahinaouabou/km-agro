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
    public function index($isSupplier, $isSubcontractor)
    {
        //
        $isSupplier = (int)$isSupplier;
        $isSubcontractor = (int)$isSubcontractor;
        $thirdParties = ThirdParty::all()
          ->where('is_supplier', $isSupplier)
          ->where('is_subcontractor', $isSubcontractor);
        //and create a view which we return - note dot syntax to go into folder
        $page = ThirdParty::getTitleActivePageByThirdPartyType($isSupplier, $isSubcontractor);
        $activePage = $page['active'];
        $titlePage = $page['title'];
        return view('thirdParties.index',compact('thirdParties','isSupplier',
                'activePage','titlePage','isSubcontractor'));
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
    public function create($isSupplier, $isSubcontractor)
    {
        //
        $page = ThirdParty::getTitleActivePageByThirdPartyType($isSupplier, $isSubcontractor);
        $activePage = $page['active'];
        $titlePage = $page['title'];       
        $isSupplier = (int)$isSupplier;
        $isSubcontractor = (int)$isSubcontractor;
        return view('thirdParties.create', 
        compact('isSupplier','isSubcontractor','activePage','titlePage'));
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
            'is_subcontractor'=> 'required',
        ]);
        $isSupplier = (int)$request->is_supplier ;
        $isSubcontractor = (int)$request->is_subcontractor ;
        $thirdParty = ThirdParty::create($validatedData);
        if ($request->ajax()) {
            $thirdParties = ThirdParty::all()->pluck('name', 'id')
            ->where('is_supplier','=',$isSupplier)
            ->where('is_subcontractor','=',$isSubcontractor);

            return response()->json([
                'selectedId'=>$thirdParty->id,
                'thirdParties'=>$thirdParties
                 ]);
        }else {
            if($isSupplier== 1){
                if($isSubcontractor==1){
                    return redirect('/thirdParty/1/1')->with('message',__('Subcontractor successfully created.'));
                } else {
                    return redirect('/thirdParty/1/0')->with('message',__('Supplier successfully created.'));
                }   
            }else {
                return redirect('/thirdParty/0/0')->with('message',__('Customer successfully created.'));
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
    public function edit($id, $isSupplier , $isSubcontractor)
    {
        //
        
        $thirdParty = ThirdParty::findOrFail($id);
        $page = ThirdParty::getTitleActivePageByThirdPartyType($isSupplier, $isSubcontractor);
        $activePage = $page['active'];
        $titlePage = $page['title'];       
        $isSupplier = (int)$isSupplier;
        $isSubcontractor = (int)$isSubcontractor;
        return view('thirdParties.edit', 
        compact('thirdParty','isSupplier','isSubcontractor','activePage','titlePage'));
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
            'is_subcontractor'=> 'required',
        ]);
        ThirdParty::whereId($id)->update($validatedData);
        $isSupplier = (int)$request->is_supplier ;
        $isSubcontractor = (int)$request->is_subcontractor ;
        if($isSupplier== 1){
            if($isSubcontractor==1){
                return redirect('/thirdParty/1/1')->with('message',__('Subcontractor successfully created.'));
            } else {
                return redirect('/thirdParty/1/0')->with('message',__('Supplier successfully created.'));
            }   
        }else {
            return redirect('/thirdParty/0/0')->with('message',__('Customer successfully created.'));
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
