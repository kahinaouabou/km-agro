<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\BlockRequest;
use App\Models\Block;
use App\Models\Room;
use App\Models\Warehouse;
use  Illuminate\Support\Facades\DB;
class BlockController extends Controller
{
 

    // function __construct()

    // {

    //     $this->middleware('auth')->except('editBloc','all');
    //     $this->middleware('permission:block-list|block-create|block-edit|block-delete', ['only' => ['index','show']]);

    //      $this->middleware('permission:block-create', ['only' => ['create','store']]);

    //      $this->middleware('permission:block-edit', ['only' => ['edit','update']]);

    //      $this->middleware('permission:block-delete', ['only' => ['destroy']]);

    // }
    
    /**
     * Display a listing of the resource.
     * @param  \App\Models\Block  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $blocks = Block:: orderBy("name","asc")->get(); 
        return view('blocks.index',compact('blocks'));    
    }
    public function all()
    {
        $blocks = DB::table('blocks')
                    ->join('warehouses', 'warehouses.id', '=', 'Blocks.warehouse_id')
                    ->select('blocks.*','warehouses.name as warehouse')->get();
        return response()->json([
            'rows'=>$blocks
             ]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouses = Warehouse::all();
        return view('blocks.create', compact('warehouses'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BlockRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlockRequest $request)
    {
       
        $validatedData = $request->validate([
            'code' => 'required|min:3',
            'name' => 'required|min:3',
            'number_rooms' => 'required',
            'warehouse_id' => 'required',
        ]);
        
        Block::create($validatedData);
        return redirect('/blocks')->with('message',__('Block successfully created.'));
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
        $block = Block::findOrFail($id);
        $warehouses = Warehouse::pluck('name', 'id');
        return view('blocks.edit', compact('block','warehouses'));
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
            'code' => 'required|min:3',
            'name' => 'required|min:3',
            'number_rooms' => 'required',
            'warehouse_id' => 'required',
        ]);
        Block::whereId($id)->update($validatedData);
        return redirect('/blocks')->with('message',__('Block successfully updated.'));
    }

    public function editBloc(Request $request,$id){
        $validatedData = $request->validate([
            'code' => 'required|min:3',
            'name' => 'required|min:3',
            'number_rooms' => 'required',
            'warehouse_id' => 'required',
        ]);
        Block::whereId($id)->update($validatedData);
        return response()->json([
            'sucsses'=>__('Block successfully updated.')
             ]);
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
            $block = Block::findOrFail($id);
            $block->delete();
            return redirect('/blocks')->with('message',__('Block successfully deleted.'));
        
        }else {
            return redirect('/blocks')->with('error',__("Block can't be deleted. Remove dependencies"));
        }
        
    }
    /**
     * @param  int  $blockId
     *
     */ 
    public function verifyDependences($blockId) {
           $exist =  Room::checkIfRoomExist($blockId);
           return $exist;
    }
}
