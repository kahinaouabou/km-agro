<?php

namespace App\Http\Controllers;

use App\Enums\PaymentTypeEnum;
use App\Models\PaymentCategory;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;
use App\Models\Bill;
use App\Models\ThirdParty;
use App\Models\Setting;
use App\Models\Company;
use App\Models\Program;
use App\Models\BillPayment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use  Illuminate\Support\Facades\DB;
use PDF;
use Config;

class PaymentController extends Controller
{
    function __construct()

    {

        $this->middleware('permission:payment-list', ['only' => ['index', 'show']]);

        $this->middleware('permission:payment-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:payment-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:payment-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //and create a view which we return - note dot syntax to go into folder   
        if ($request->ajax()) {

            $selected_id = [];
            if (!empty($request->third_party_id)) {
                $selected_id['third_party_id'] = $request->third_party_id;
            } else {
                $selected_id['third_party_id'] = '';
            }
            if (!empty($request->payment_category_id)) {
                $selected_id['payment_category_id'] = $request->payment_category_id;
            } else {
                $selected_id['payment_category_id'] = '';
            }
            if (!empty($request->payment_type)) {
                $selected_id['payment_type'] = $request->payment_type;
            } else {
                $selected_id['payment_type'] = '';
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
            $currentProgramId = auth()->user()->program_id;;
            $sumReceipts = Payment::getSumAmounts($request, PaymentTypeEnum::Receipt, $currentProgramId);
            $sumDisbursements = Payment::getSumAmounts($request, PaymentTypeEnum::Disbursement, $currentProgramId);

            $data = DB::table('payments')
                ->join('third_parties as ThirdParty', 'ThirdParty.id', '=', 'payments.third_party_id')
                ->leftjoin('payment_categories as PaymentCategory', 'PaymentCategory.id', '=', 'payments.payment_category_id')

                ->select(
                    'payments.*',
                    'ThirdParty.name as thirdPartyName',
                    'PaymentCategory.name as categoryName'
                    //DB::raw("DATE_FORMAT(payments.payment_date, '%d/%m/%Y') as payment_date")
                )
                ->where('program_id', '=', $currentProgramId)
                ->where(function ($query) use ($request) {
                    return $request->get('third_party_id') ?
                        $query->from('payments')->where('third_party_id', $request->get('third_party_id')) : '';
                })
                ->where(function ($query) use ($request) {
                    return $request->get('payment_category_id') ?
                        $query->from('payments')->where('payment_category_id', $request->get('payment_category_id')) : '';
                })

                ->where(function ($query) use ($request) {
                    return $request->get('payment_type') ?
                        $query->from('payments')->where('payment_type', Config::get('constants.' . $request->payment_type)) : '';
                })

                ->where(function ($query) use ($request) {
                    return $request->get('date_from') ?
                        $query->from('payments')->where('payment_date', '>=', $request->get('date_from')) : '';
                })
                ->where(function ($query) use ($request) {
                    return $request->get('date_to') ?
                        $query->from('payments')->where('payment_date', '<=', $request->get('date_to')) : '';
                })
                ->orderBy("payment_date", "desc");
            return Datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('sumAmount', function() use ($sumAmount){
                //     return  number_format($sumAmount, 2, ',', ' ');
                // })
                ->editColumn('payment_type', function ($row) {
                    return  __(Config::get('constants.' . $row->payment_type));
                })
                ->setRowClass(function ($row) {

                    return $row->payment_type == 1 ? ('row-danger') : ('row-success');
                })
                ->addColumn('sumReceipts', function () use ($sumReceipts) {
                    return  number_format($sumReceipts, 2, ',', ' ');
                })
                ->addColumn('sumDisbursements', function () use ($sumDisbursements) {
                    return  number_format($sumDisbursements, 2, ',', ' ');
                })
                ->addColumn('action', function ($row) {
                    $routeView =  route("payments.show", $row->id);
                    $routeEdit =  route("payments.edit", $row->id);
                    $routePrint =  route("payments.print", $row->id);
                    $routeDelete = route("payments.destroy", $row->id);
                    $idDestroy = "destroy" . $row->id;
                    $btn = '
                        <a rel="tooltip" class="btn btn-primary btn-link" href=' . $routeView . ' data-original-title="" title="">
                        <i class="material-icons">visibility</i>
                        <div class="ripple-container"></div>
                            </a>
                        <a rel="tooltip" class="btn btn-success btn-link edit-payment-button" href=' . $routeEdit . ' data-original-title="" title="">
                        <i class="material-icons">edit</i>
                        <div class="ripple-container"></div>
                            </a>
                        <a rel="tooltip" class="btn btn-warning btn-link" href=' . $routePrint . ' data-original-title="" title="" target="_blank">
                            <i class="material-icons">print</i>
                            <div class="ripple-container"></div>
                        </a>    
                        <a rel="tooltip" class="btn btn-danger btn-link"
                        onclick="event.preventDefault(); document.getElementById(' . $idDestroy . ').submit();" data-original-title="" title="">
                        <i class="material-icons">delete</i>
                            <div class="ripple-container"></div>  
                            </a>
                            <form id=' . $idDestroy . ' action=' . $routeDelete . ' method="POST" style="display: none;">
                                @csrf
                                @method("DELETE")
                            </form>
                            <button type="button" class="" data-toggle="tooltip" 
                            data-placement="bottom" title="' . $row->observation . '">
                            Obs
                            </button>
                            
                            ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $selected_id = [];
        $selected_id['third_party_id'] = $request->third_party_id;
        $selected_id['payment_category_id'] = $request->payment_category_id;
        $selected_id['payment_type'] = $request->payment_type;
        $selected_id['date_from'] = $request->date_from;
        $selected_id['date_to'] = $request->date_to;

        return view('payments.index', compact('selected_id'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $nextReference = Setting::getNextReferenceByFieldName('payment');
        $page = Payment::getTitleActivePageByPaymentType($type);
        $thirdParties = ThirdParty::getThirdPartiesByType($type);
        $paymentCategories = PaymentCategory::all();

        return view('payments.create', compact('nextReference', 'page', 'thirdParties', 'type', 'paymentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([

            'reference' => 'required|min:3',
            'third_party_id' => 'required',
            'amount' => 'required',
            'payment_type' => 'required',
            'payment_date' => 'required',
            'observation' => 'nullable',
            'payment_category_id' => 'nullable'
        ]);
        $currentProgramId = auth()->user()->program_id;
        $validatedData['program_id'] = $currentProgramId;
        $payment = Payment::create($validatedData);
        Setting::setNextReferenceNumber('payment');
        if ($request->ajax()) {
            $this->addAssociationPaymentBills($request, $payment);
        }
        return redirect('/payments')->with('message', __('Payment successfully created.'));




        //  


    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentBills = BillPayment::where('payment_id', $id)->get();
        $payment = Payment::findOrFail($id);
        return view('payments.show', compact('paymentBills', 'payment'));
    }
    public function getReference()
    {
        $nextReference = Setting::getNextReferenceByFieldName('payment');
        return response()->json([
            'reference' => $nextReference
        ]);
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
        $payment = Payment::findOrFail($id);

        $thirdParties = ThirdParty::getThirdPartiesByType($payment->payment_type);
        $paymentCategries = PaymentCategory::pluck('name', 'id');
        return view('payments.edit', compact('payment', 'thirdParties', 'paymentCategries'));
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
        $precedentPayment = Payment::findOrFail($id);

        $validatedData = $request->validate([

            'reference' => 'required|min:3',
            'third_party_id' => 'required',
            'amount' => 'required',
            'payment_type' => 'required',
            'payment_date' => 'required',
            'observation' => 'nullable',
            'payment_category_id' => 'nullable'
        ]);
        Payment::whereId($id)->update($validatedData);

        $actualPayment = Payment::findOrFail($id);
        if (($actualPayment->amount != $precedentPayment->amount) ||
            ($actualPayment->third_party_id != $precedentPayment->third_party_id)
        ) {
            BillPayment::where('payment_id', $id)->delete();
        }

        return redirect('/payments')->with('message', __('Payment successfully updated.'));
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

    public function print($id)
    {
        $payment = Payment::findOrFail($id);
        $paymentName = __('Payment') . '-' . $payment->reference;
        $company = Company::first();
        $paymentBills = BillPayment::where('payment_id', $id)->get();
        $pdf = PDF::loadView(
            'payments.pdf.print',
            compact('payment', 'paymentName', 'company', 'paymentBills')
        );
        return $pdf->stream($paymentName . '.pdf');
    }

    public function printSituation(Request $request)
    {


        $payments = DB::table('payments')
            ->join('third_parties as ThirdParty', 'ThirdParty.id', '=', 'payments.third_party_id')
            ->select(
                'payments.*',
                'ThirdParty.name as thirdPartyName',
            )
            ->where(function ($query) use ($request) {
                return $request->get('third_party_id') ?
                    $query->from('payments')->where('third_party_id', $request->get('third_party_id')) : '';
            })
            ->where(function ($query) use ($request) {
                return $request->get('payment_type') ?
                    $query->from('payments')->where('payment_type', Config::get('constants.' . $request->payment_type)) : '';
            })

            ->where(function ($query) use ($request) {
                return $request->get('date_from') ?
                    $query->from('payments')->where('payment_date', '>=', $request->get('date_from')) : '';
            })
            ->where(function ($query) use ($request) {
                return $request->get('date_to') ?
                    $query->from('payments')->where('payment_date', '<=', $request->get('date_to')) : '';
            })
            ->orderBy("payment_date", "desc")->get();

        $company = Company::first();
        $thirdParty = ThirdParty::find($request->third_party_id);

        $pdf = PDF::loadView(
            'payments.pdf.printSituation',
            compact('payments', 'company', 'thirdParty')
        );

        $paymentsName = __('Payments situation');
        return $pdf->stream($paymentsName . '.pdf');
    }
    public function addAssociationPaymentBills($request, $payment)
    {
        $billIds = JSON_decode($request->billIds);

        $bills = Bill::whereIn('id', $billIds)
            ->where('net_remaining', '>', 0)
            ->orderBy('bill_date', 'asc')
            ->orderBy('reference', 'asc')
            ->get();

        $totalAmount = $request->amount;
        if ($totalAmount > 0) {
            foreach ($bills as $bill) {
                $netRemainingBill = $bill->net_remaining;
                if ($totalAmount >= $netRemainingBill) {
                    $amountPaid = $netRemainingBill;
                    $netRemaining = 0;
                    $totalAmount = $totalAmount - $netRemainingBill;
                } else {
                    $amountPaid = $totalAmount;
                    $netRemaining = $netRemainingBill - $totalAmount;
                    $totalAmount = 0;
                }
                $params = [
                    'bill_id' => $bill->id,
                    'payment_id' => $payment->id,
                    'amount_paid' => $amountPaid,
                ];
                if (BillPayment::insertBillPayment($params)) {
                    Bill::where('id', $bill->id)->update(['net_remaining' => $netRemaining]);
                    Payment::where('id', $payment->id)->update(['amount_remaining' => $totalAmount]);
                }
            }
        }
        return response()->json(['success' => $bills]);
    }

    public function getReceiptsByThirdPartyId($thirdPartyId, $paymentTypeId)
    {


        // $payments = DB::table('payments')
        // ->leftjoin('bill_payment as BillPayment', 'BillPayment.payment_id', '=', 'payments.id')   
        // ->select(
        // //DB::raw('amount-SUM(amount_paid) as rest')  , 
        // 'payments.*','BillPayment.*')
        // ->where('third_party_id', $thirdPartyId)
        // ->where('payment_type',PaymentTypeEnum::Receipt)
        // //->having('rest', '=',null)
        // //->groupBy('payments.id')
        // ->orderBy('payment_date', 'asc')
        // ->orderBy('reference', 'asc')
        // ->get();
        $payments = DB::table('payments')
            ->select('payments.*', DB::raw("DATE_FORMAT(payments.payment_date, '%d/%m/%Y') as payment_date"))
            ->where('third_party_id', $thirdPartyId)
            ->where('payment_type', $paymentTypeId)
            ->orderBy('payment_date', 'asc')
            ->orderBy('reference', 'asc')
            ->get();

        $receipts = [];
        if (!empty($payments)) {

            foreach ($payments as $payment) {
                $sumAmountPaid = BillPayment::where('payment_id', $payment->id)->sum('amount_paid');
                if ($payment->amount > $sumAmountPaid) {
                    $rest = $payment->amount - $sumAmountPaid;
                    $payment->rest = $rest;
                    $receipts[] = $payment;
                }
            }
        }
        return view('payments.getReceiptsByThirdPartyId', compact('receipts'));
    }

    public function getReceiptsByPaymentIds($paymentIds, $paymentTypeId)
    {


        $payments = DB::table('payments')
            ->select('payments.*', DB::raw("DATE_FORMAT(payments.payment_date, '%d/%m/%Y') as payment_date"))
            ->whereIn('id', $paymentIds)
            ->where('payment_type', $paymentTypeId)
            ->orderBy('payment_date', 'asc')
            ->orderBy('reference', 'asc')
            ->get();
        $receipts = [];
        if (!empty($payments)) {

            foreach ($payments as $payment) {
                $sumAmountPaid = BillPayment::where('payment_id', $payment->id)->sum('amount_paid');
                if ($payment->amount > $sumAmountPaid) {
                    $rest = $payment->amount - $sumAmountPaid;
                    $payment->rest = $rest;
                    $receipts[] = $payment;
                }
            }
        }
        return $receipts;
    }

    public function associatePaymentsBills(Request $request)
    {

        // if ($request->ajax()) {

        $billIds = JSON_decode($request->billIds);
        $paymentIds = JSON_decode($request->paymentIds);
        $paymentTypeId = JSON_decode($request->paymentTypeId);

        $bills = Bill::whereIn('id', $billIds)
            ->where('net_remaining', '>', 0)
            ->orderBy('bill_date', 'asc')
            ->orderBy('reference', 'asc')
            ->get();


        $j = 0;
        $nbBills = count($bills);
        $payments = $this->getReceiptsByPaymentIds($paymentIds, $paymentTypeId);

        $amountPaid = 0;

        foreach ($payments as $payment) {

            $payrollAmount = $payment->rest;
            while ($payrollAmount > 0 && $j < $nbBills) {

                $bill = $bills[$j];
                $amountRemainingBill = $bill->net_remaining - $amountPaid;

                if ($payrollAmount >= $amountRemainingBill) {
                    $amountPaid = $amountRemainingBill;
                    $amountRemaining = 0;

                    $payrollAmount = $payrollAmount - $amountRemainingBill;
                } else {
                    $amountPaid = $amountPaid + $payrollAmount;
                    $amountRemaining = $amountRemainingBill - $payrollAmount;
                    $payrollAmount = 0;
                }
                $params = [
                    'bill_id' => $bill->id,
                    'payment_id' => $payment->id,
                    'amount_paid' => $amountPaid,
                ];

                if (BillPayment::insertBillPayment($params)) {

                    Bill::where('id', $bill->id)->update(['net_remaining' => $amountRemaining]);
                    Payment::where('id', $payment->id)->update(['amount_remaining' => $payrollAmount]);
                }

                if ($amountRemaining == 0) {
                    $j++;
                    $amountPaid = 0;
                }
            }
        }


        return response()->json(['success' => $bills]);


        //}


    }
}
