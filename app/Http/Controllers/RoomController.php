<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Models\Block;
use App\Models\Bill;
use App\Models\Company;
use PDF;
class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \App\Models\Room  $model
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $rooms = Room::where( function($query) use($request){
            return $request->block_id ?
                   $query->from('rooms')->where('block_id',$request->block_id) : '';
        })
        ->where( function($query) use($request){
            return $request->get('room_id') ?
                    $query->from('rooms')->whereIn('id',$request->room_id) : '';})           
       
       ->get();

$selected_id = [];
if(!empty($request->block_id)){
$selected_id['block_id'] = $request->block_id;
}else {
$selected_id['block_id'] = '';
}
if(!empty($request->room_id)){
    $selected_id['room_id'] = $request->room_id;
    }else {
    $selected_id['room_id'] = '';
    }


        return view('rooms.index',compact('rooms','selected_id')); 
        //
    }

    function print (Request $request) {
        
       
        $rooms = Room::where( function($query) use($request){
            return $request->block_id ?
                   $query->from('rooms')->where('block_id',$request->block_id) : '';
                   
        })
        ->where( function($query) use($request){
            return $request->get('room_id') ?
                    $query->from('rooms')->whereIn('id',$request->room_id) : '';}) 
       ->get();
        $roomName = __('Rooms');
        $company = Company::first();
      
        $pdf = PDF::loadView('rooms.pdf.print', 
        compact('rooms','company'));
        
        return $pdf->stream($roomName.'.pdf');
    }
   


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blocks = Block::all();
        
        return view('rooms.create', compact('blocks'));
        //
    }

 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        //
        $validatedData = $request->validate([
            'code' => 'required|min:3',
            'name' => 'required|min:3',
            'length'=>'required',
            'width'=>'required',
            'height'=>'required',
            'volume'=>'required',
            'stored_quantity'=>'required',
            'block_id' => 'required',
        ]);
        $room = Room::create($validatedData);
        return redirect('/rooms')->with('message',__('Room successfully created.'));
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
        $room = Room::findOrFail($id);
        $blocks = Block::pluck('name', 'id');
        $sumUnstockedQuantity = Bill::getSumUnstockedQuantityByRoomId($id);
        return view('rooms.edit', compact('room','blocks','sumUnstockedQuantity'));
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
            'length'=>'required',
            'width'=>'required',
            'height'=>'required',
            'volume'=>'required',
            'stored_quantity'=>'required',
            'unstocked_quantity'=>'required',
            'damaged_quantity'=>'required',
            'weightloss_value'=>'required',
            'loss_value'=>'required',
            'loss_percentage'=>'required',
            'block_id' => 'required',
        ]);
        if(Room::whereId($id)->update($validatedData)){
            return redirect('/rooms')->with('message',__('Room successfully updated.'));
        }else {
            return redirect('/rooms.edit')->with('message',__('Room not updated.'));
        }
        ;
        //dd($room);
        
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
        $room = Room::findOrFail($id);
        
        $room->delete();
        return redirect('/rooms')->with('message',__('Room successfully deleted.'));
    }

    public function getRoomsByBlock($blockId = null){
        $rooms = Room::all()->where('block_id','=',$blockId)->pluck('name', 'id');

        return response()->json([
            'rooms'=>$rooms
             ]);
    }
}
