<?php

namespace App\Http\Controllers;


use App\Enums\ThirdPartyEnum;
use App\Models\ThirdParty;
use App\Models\TransactionBox;
use App\Models\Bill;
use App\Models\Company;
use App\Models\Program;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\DB;
use PDF;

class TransactionBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()

    {

        $this->middleware('permission:transaction-box-list', ['only' => ['index', 'show']]);

        $this->middleware('permission:transaction-box-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:transaction-box-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:transaction-box-delete', ['only' => ['destroy']]);
    }

    function index(Request $request)
    {

        $transactionBoxes = TransactionBox::where('third_party_id', '!=', 24)
            ->where(function ($query) use ($request) {
                return $request->third_party_id ?
                    $query->from('transactionBoxes')->where('third_party_id', $request->third_party_id) : '';
            })->where(function ($query) use ($request) {
                return $request->date_from ?
                    $query->from('transactionBoxes')->where('transaction_date', '>=', $request->date_from) : '';
            })->where(function ($query) use ($request) {
                return $request->date_to ?
                    $query->from('transactionBoxes')->where('transaction_date', '<=', $request->date_to) : '';
            })
            ->orderBy('transaction_date', 'asc')
            ->get();

        $selected_id = [];
        if (!empty($request->third_party_id)) {
            $selected_id['third_party_id'] = $request->third_party_id;
        } else {
            $selected_id['third_party_id'] = '';
        }
        if (!empty($request->date_from)) {
            $selected_id['date_from'] = $request->date_from;
        } else {
            $selected_id['date_from'] = '';
        }
        if (!empty($request->date_to)) {
            $selected_id['date_to'] = $request->date_to;
        } else {
            $selected_id['date_to'] = '';
        }

        $countReturnedBoxes = TransactionBox::where('third_party_id', '!=', 24)
            ->where(function ($query) use ($request) {
                return $request->third_party_id ?
                    $query->from('transactionBoxes')->where('third_party_id', $request->third_party_id) : '';
            })->where(function ($query) use ($request) {
                return $request->date_from ?
                    $query->from('transactionBoxes')->where('transaction_date', '>=', $request->date_from) : '';
            })->where(function ($query) use ($request) {
                return $request->date_to ?
                    $query->from('transactionBoxes')->where('transaction_date', '<=', $request->date_to) : '';
            })->sum('number_boxes_returned');
        $countTakenBoxes = TransactionBox::where('third_party_id', '!=', 24)
            ->where(function ($query) use ($request) {
                return $request->third_party_id ?
                    $query->from('transactionBoxes')->where('third_party_id', $request->third_party_id) : '';
            })->where(function ($query) use ($request) {
                return $request->date_from ?
                    $query->from('transactionBoxes')->where('transaction_date', '>=', $request->date_from) : '';
            })->where(function ($query) use ($request) {
                return $request->date_to ?
                    $query->from('transactionBoxes')->where('transaction_date', '<=', $request->date_to) : '';
            })->sum('number_boxes_taken');
        return view(
            'transactionBoxes.index',
            compact('transactionBoxes', 'selected_id', 'countReturnedBoxes', 'countTakenBoxes')
        );
    }

    function print(Request $request)
    {


        $transactionBoxes = TransactionBox::where('third_party_id', '!=', 24)
            ->where(function ($query) use ($request) {
                return $request->third_party_id ?
                    $query->from('transactionBoxes')->where('third_party_id', $request->third_party_id) : '';
            })->where(function ($query) use ($request) {
                return $request->date_from ?
                    $query->from('transactionBoxes')->where('transaction_date', '>=', $request->date_from) : '';
            })->where(function ($query) use ($request) {
                return $request->date_to ?
                    $query->from('transactionBoxes')->where('transaction_date', '<=', $request->date_to) : '';
            })->get();
        $transactionBoxName = __('Transaction boxes');
        $company = Company::first();
        $thirdParty = ThirdParty::find($request->third_party_id);

        $pdf = PDF::loadView(
            'transactionBoxes.pdf.print',
            compact('transactionBoxes', 'company', 'thirdParty')
        );

        return $pdf->stream($transactionBoxName . '.pdf');
    }

    function printGlobal(Request $request)
    {


        $transactionBoxes = TransactionBox::where('third_party_id', '!=', 24)
            ->where(function ($query) use ($request) {
                return $request->third_party_id ?
                    $query->from('transactionBoxes')->where('third_party_id', $request->third_party_id) : '';
            })->where(function ($query) use ($request) {
                return $request->date_from ?
                    $query->from('transactionBoxes')->where('transaction_date', '>=', $request->date_from) : '';
            })->where(function ($query) use ($request) {
                return $request->date_to ?
                    $query->from('transactionBoxes')->where('transaction_date', '<=', $request->date_to) : '';
            })
            ->join('third_parties as ThirdParty', 'ThirdParty.id', '=', 'transaction_boxes.third_party_id')
            ->select([
                'ThirdParty.name', 'ThirdParty.phone',
                DB::raw("SUM(number_boxes_returned) as sum_number_boxes_returned"),
                DB::raw("SUM(number_boxes_taken) as sum_number_boxes_taken")
            ])
            ->groupBy('third_party_id')
            ->orderBy('third_party_id')
            ->get();
        $transactionBoxName = __('Transaction boxes');
        $company = Company::first();
        $thirdParty = ThirdParty::find($request->third_party_id);

        $pdf = PDF::loadView(
            'transactionBoxes.pdf.printGlobal',
            compact('transactionBoxes', 'company', 'thirdParty')
        );

        return $pdf->stream($transactionBoxName . '.pdf');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $thirdParties = ThirdParty::getThirdPartiesByType(ThirdPartyEnum::Customer);
        return view('transactionBoxes.create', compact('thirdParties'));
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
            'number_boxes_returned' => 'required',
        ]);
        $currentProgramId = auth()->user()->program_id;
        $validatedData['program_id'] = $currentProgramId;
        TransactionBox::create($validatedData);
        return redirect('/transactionBoxes')->with('message', __('Returned boxes successfully created.'));
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
        $thirdParties = ThirdParty::where('is_supplier', ThirdPartyEnum::Customer)->pluck('name', 'id');
        return view('transactionBoxes.edit', compact('transactionBox', 'thirdParties'));
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
            'number_boxes_returned' => 'required',
            'number_boxes_taken' => 'required',
        ]);
        TransactionBox::whereId($id)->update($validatedData);
        if (!empty($request->bill_id)) {
            Bill::whereId($request->bill_id)->update(['number_boxes_returned' => $request->number_boxes_returned]);
        }
        return redirect('/transactionBoxes')->with('message', __('Returned boxes successfully updated.'));
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
