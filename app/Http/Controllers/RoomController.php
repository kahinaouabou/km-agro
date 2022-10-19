<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Models\Block;
class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \App\Models\Room  $model
     * @return \Illuminate\Http\Response
     */
    public function index(Room $model)
    {
        $rooms = Room::all();
        return view('rooms.index',compact('rooms')); 
        //
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
        return view('rooms.edit', compact('room','blocks'));
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
}
