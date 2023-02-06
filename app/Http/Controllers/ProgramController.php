<?php

namespace App\Http\Controllers;

use App\Models\TransactionBox;
use App\Models\Bill;
use Illuminate\Http\Request;
use App\Http\Requests\ProgramRequest;
use App\Models\Program;
class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Program $model)
    {
        //
        $programs = $model->paginate(15);
        return view('programs.index',compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('programs.create');
    }

     /**
     * Store a newly created resource in storage.
     *
     * 
     * @param  \Illuminate\Http\ProgramRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramRequest $request)
    {
       $validatedData = $request->validate([
            'code' => 'required|min:3',
            'name' => 'required|min:3'
        ]);
        
        $program=Program::create($validatedData);
       
        return redirect('/programs')->with('message',__('Program successfully created.'));
    
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
        $program = Program::findOrFail($id);
        return view('programs.edit', compact('program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramRequest $request, $id)
    {
        //
        
      
        
        $validatedData = $request->validate([
            'code' => 'required|min:3',
            'name' => 'required|min:3',
        ]);
        
        Program::whereId($id)->update($validatedData);
       
        return redirect('/programs')->with('message',__('Program successfully updated.'));
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
            $program = Program::findOrFail($id);
            $program->delete();
            return redirect('/programs')->with('message',__('Program successfully deleted.'));
        }else {
            return redirect('/programs')->with('error',__("Program can't be deleted. Remove dependencies"));
        }
    }
    public function verifyDependences($programId) {
        $exist =  Bill::checkIfBillExist($programId);
        if(!$exist){
            $exist =  TransactionBox::checkIfTransactionBoxExist($programId);
        }
        return $exist;
    }

    public function makeProgramCurrent($id){

    }
}
