<?php

namespace App\Http\Controllers;
use App\Http\Requests\WarehouseRequest;
use App\Models\Block;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \App\Models\Warehouse  $model
     * @return \Illuminate\Http\Response
     */
    // public function index(Warehouse $model)
    // {
    //     //
    //     $warehouses = $model->paginate(15);
    //     return view('warehouses.index',compact('warehouses')); 
    // }

    public function index(Request $request)

    {
        
        if ($request->ajax()) {

            $data = Warehouse::select('*');

            return Datatables::of($data)

                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $routeEdit =  route("warehouses.edit", $row->id) ;
                        $routeDelete = route("warehouses.destroy", $row->id);
                        $idDestroy = "destroy".$row->id;
                        $btn ='
                        <div class ="div-action-2">
                        <a rel="tooltip" class="btn  btn-success btn-link" href='.$routeEdit.' data-original-title="" title="">
                        <i class="material-icons">edit</i>
                            </a> 
                            <form action='.$routeDelete.' method="POST">
                    '.csrf_field().'
                    '.method_field("DELETE").'
                    <button type="submit" rel="tooltip" class="btn  btn-danger btn-link"
                        onclick="return confirm(\'Are You Sure Want to Delete?\')"
                        style="padding: .0em !important;font-size: xx-small;"><i class="material-icons">delete</i></button>
                    </form> </div>';
                            return $btn;
                    })

                    ->rawColumns(['action'])

                    ->make(true);

        }

        

        return view('warehouses.index');

    }

    public function all (){
        $warehouses = Warehouse::all();
        return response()->json([
            'warehouses'=>$warehouses
             ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\WarehouseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WarehouseRequest $request)
    {
        //
        $validatedData = $request->validate([
            'code' => 'required|min:3',
            'name' => 'required|min:3',
            'address' => 'required',
        ]);
        Warehouse::create($validatedData);
        return redirect('/warehouses')->with('message',__('Warehouse successfully created.'));
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
        $warehouse = Warehouse::findOrFail($id);
        return view('warehouses.edit', compact('warehouse'));
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
        ]);
        Warehouse::whereId($id)->update($validatedData);
        return redirect('/warehouses')->with('message',__('Warehouse successfully updated.'));
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
        $dependences =$this->verifyDependences($id);
        if(!$dependences){
            $warehouse = Warehouse::findOrFail($id);
            $warehouse->delete();
            return redirect('/warehouses')->with('message',__('Warehouse successfully deleted.'));
        }else {
            return redirect('/warehouses')->with('error',__("warehouse can't be deleted. Remove dependencies"));
        }
    }
     /**
     * @param  int  $warehouseId
     *
     */ 
    public function verifyDependences($warehouseId) {
        $exist =  Block::checkIfBlockExist($warehouseId);
        return $exist;
    }
}
