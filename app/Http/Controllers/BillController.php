<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Pivot;
use App\Models\Product;
use App\Models\Truck;
use App\Models\Block;
use App\Models\Room;
use App\Models\Driver;
use App\Models\Parcel;
use App\Models\ThirdParty;
use App\Models\BillPayment;
use App\Models\Payment;
use App\Models\Company;
use App\Models\Variety;
use Illuminate\Http\Request;
use App\Http\Requests\BillRequest;
use App\Enums\BillTypeEnum;
use App\Enums\ThirdPartyEnum;
use App\Http\Requests\TransactionBoxRequest;
use App\Models\TransactionBox;
use App\Models\Setting;
use App\Models\Program;
use PDF;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\DB;

class BillController extends Controller
{

    function __construct()

    {


        $this->middleware('permission:bill-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:bill-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $type
     * @return \Illuminate\Http\Response
     */
    public function index($type, Request $request)
    {
        //

        if ($type == BillTypeEnum::DeliveryBill) {
            $this->middleware('permission:delivery-bill-list', ['only' => ['index', 'show']]);
        } else {
            $this->middleware('permission:bill-list', ['only' => ['index', 'show']]);
        }
        $bills = Bill::where('bill_type', $type)->paginate(15);

        //and create a view which we return - note dot syntax to go into folder
        switch ($type) {
            case BillTypeEnum::EntryBill:
                $dbBillType = BillTypeEnum::EntryBill;
                break;
            case BillTypeEnum::ExitBill:
            case BillTypeEnum::WeighBill:
                $dbBillType = BillTypeEnum::ExitBill;
                break;
            case BillTypeEnum::DamageBill:
                $dbBillType = BillTypeEnum::DamageBill;
                break;
            case BillTypeEnum::DeliveryBill:
                $dbBillType = BillTypeEnum::DeliveryBill;
                break;
            case BillTypeEnum::SubcontractingBill:
                $dbBillType = BillTypeEnum::SubcontractingBill;
                break;
            case BillTypeEnum::OrderBill:
                $dbBillType = BillTypeEnum::OrderBill;
                break;    
        }

        if ($request->ajax()) {

            $selected_id = [];
            if (!empty($request->third_party_id)) {
                $selected_id['third_party_id'] = $request->third_party_id;
            } else {
                $selected_id['third_party_id'] = '';
            }
            if (!empty($request->driver_id)) {
                $selected_id['driver_id'] = $request->driver_id;
            } else {
                $selected_id['driver_id'] = '';
            }
            if (!empty($request->truck_id)) {
                $selected_id['truck_id'] = $request->truck_id;
            } else {
                $selected_id['truck_id'] = '';
            }
            if (!empty($request->block_id)) {
                $selected_id['block_id'] = $request->block_id;
            } else {
                $selected_id['block_id'] = '';
            }
            if (!empty($request->room_id)) {
                $selected_id['room_id'] = $request->room_id;
            } else {
                $selected_id['room_id'] = '';
            }

            if (!empty($request->net_remaining)) {
                $selected_id['net_remaining'] = $request->net_remaining;
            } else {
                $selected_id['net_remaining'] = '';
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
            $sumNet = Bill::getSumNet($request, $dbBillType, $currentProgramId);
            $sumNetPayable = Bill::getSumNetPayable($request, $dbBillType, $currentProgramId);
            $sumNetRemaining = Bill::getSumNetRemaining($request, $dbBillType, $currentProgramId);
            $sumNetPaid = $sumNetPayable - $sumNetRemaining;
            $sumNbBoxes = Bill::getSumNbBoxes($request, $dbBillType, $currentProgramId);
            $limit = request('length');
            $start = request('start');

            $data = DB::table('bills')
                ->join('products as Product', 'Product.id', '=', 'bills.product_id')
                ->leftjoin('varieties as Variety', 'Variety.id', '=', 'bills.variety_id')
                ->leftjoin('third_parties as ThirdParty', 'ThirdParty.id', '=', 'bills.third_party_id')
                ->leftjoin('blocks as Block', 'Block.id', '=', 'bills.block_id')
                ->leftjoin('rooms as Room', 'Room.id', '=', 'bills.room_id')
                ->leftjoin('trucks as Truck', 'Truck.id', '=', 'bills.truck_id')
                ->leftjoin('drivers as Driver', 'Driver.id', '=', 'bills.driver_id')
                ->select(
                    DB::raw('bills.net_payable - bills.net_remaining as net_paid'),
                    'bills.*',
                    'Product.name as productName',
                    'Variety.name as varietyName',
                    'Block.name as blockName',
                    'Room.name as roomName',
                    'Truck.registration as truckName',
                    'Driver.name as driverName',
                    'ThirdParty.name as thirdPartyName'
                )
                // DB::raw("DATE_FORMAT(bills.bill_date, '%d/%m/%Y') as bill_date") )
                ->where('bill_type', '=', $dbBillType)
                ->where('program_id', '=', $currentProgramId)
                ->where(function ($query) use ($request) {
                    return $request->get('third_party_id') ?
                        $query->from('bills')->where('bills.third_party_id', $request->get('third_party_id')) : '';
                })
                ->where(function ($query) use ($request) {
                    return $request->get('driver_id') ?
                        $query->from('bills')->where('bills.driver_id', $request->get('driver_id')) : '';
                })
                ->where(function ($query) use ($request) {
                    return $request->get('truck_id') ?
                        $query->from('bills')->where('bills.truck_id', $request->get('truck_id')) : '';
                })
                ->where(function ($query) use ($request) {
                    return $request->get('block_id') ?
                        $query->from('bills')->whereIn('bills.block_id', $request->get('block_id')) : '';
                })
                ->where(function ($query) use ($request) {
                    return $request->get('room_id') ?
                        $query->from('bills')->whereIn('room_id', $request->get('room_id')) : '';
                })
                ->where(function ($query) use ($request) {
                    return $request->get('net_remaining') ?
                        $query->from('bills')->where('bills.net_remaining', $request->get('net_remaining'), 0) : '';
                })

                ->where(function ($query) use ($request) {
                    return $request->get('date_from') ?
                        $query->from('bills')->where('bill_date', '>=', $request->get('date_from')) : '';
                })
                ->where(function ($query) use ($request) {
                    return $request->get('date_to') ?
                        $query->from('bills')->where('bill_date', '<=', $request->get('date_to')) : '';
                })
                ->orderBy("bill_date", "desc");

            return Datatables::of($data)

                ->addIndexColumn()
                ->editColumn('raw', function ($row) {
                    return number_format($row->raw, 0, ',', ' ');
                })
                ->editColumn('tare', function ($row) {
                    return number_format($row->tare, 0, ',', ' ');
                })
                ->editColumn('net', function ($row) {
                    return number_format($row->net, 0, ',', ' ');
                })
                ->editColumn('number_boxes', function ($row) {
                    return number_format($row->number_boxes, 0, ',', ' ');
                })
                ->editColumn('net_payable', function ($row) {
                    return number_format($row->net_payable, 2, ',', ' ');
                })
                ->editColumn('net_remaining', function ($row) {
                    return number_format($row->net_remaining, 2, ',', ' ');
                })
                ->editColumn('net_paid', function ($row) {
                    return number_format($row->net_paid, 2, ',', ' ');
                })
                ->addColumn('sumNet', function () use ($sumNet) {
                    return  number_format($sumNet, 2, ',', ' ');
                })
                ->addColumn('inputSumNet', function () use ($sumNet) {
                    return  $sumNet;
                })
                ->addColumn('sumNetPayable', function () use ($sumNetPayable) {
                    return number_format($sumNetPayable, 2, ',', ' ');
                })
                ->addColumn('sumNetRemaining', function () use ($sumNetRemaining) {
                    return number_format($sumNetRemaining, 2, ',', ' ');
                })
                ->addColumn('sumNetPaid', function () use ($sumNetPaid) {
                    return number_format($sumNetPaid, 2, ',', ' ');
                })
                ->addColumn('sumNbBoxes', function () use ($sumNbBoxes) {
                    return number_format($sumNbBoxes, 0, ',', ' ');
                })


                ->addColumn('selected_id', function () use ($selected_id) {
                    return $selected_id;
                })

                ->addColumn('action', function ($row) use ($type) {
                    $routeShow = route("bills.show", [$row->id, $type]);
                    $routeEdit =  route("bills.edit", [$row->id, $type]);
                    $routeDelete = route("bills.destroy", $row->id);
                    $routePrint = route("bills.printBill", [$row->id, $type]);
                    $idDestroy = "destroy" . $row->id;
                    if ($type == BillTypeEnum::ExitBill) {
                        $btn = '<a rel="tooltip" class="btn btn-action btn-primary btn-link" 
                        href=' . $routeShow . ' data-original-title="" title="">
                        <i class="material-icons">visibility</i>
                        <div class="ripple-container"></div>
                            </a>';
                    } else {
                        $btn = '';
                    }
                    $btn = $btn . '<a rel="tooltip" class="btn btn-action btn-success btn-link edit-bill-button" 
                        href=' . $routeEdit . ' data-original-title="" title="">
                        <i class="material-icons">edit</i>
                        <div class="ripple-container"></div>
                            </a>
                            <a rel="tooltip" class="btn btn-action btn-warning btn-link" href=' . $routePrint . ' data-original-title="" title="" target="_blank">
                        <i class="material-icons">print</i>
                        <div class="ripple-container"></div>
                            </a>
                        <a rel="tooltip" class="btn btn-action btn-danger btn-link"
                        onclick="event.preventDefault(); document.getElementById(' . $idDestroy . ').submit();" data-original-title="" title="">
                        <i class="material-icons">delete</i>
                            <div class="ripple-container"></div>  
                            </a>
                            <form id=' . $idDestroy . ' action=' . $routeDelete . ' method="POST" style="display: none;">
                                @csrf
                                @method("DELETE")
                            </form>
                            ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page = Bill::getTitleActivePageByTypeBill($type);
        $selected_id = [];
        if (!empty($request->third_party_id)) {
            $selected_id['third_party_id'] = $request->third_party_id;
        } else {
            $selected_id['third_party_id'] = '';
        }
        if (!empty($request->driver_id)) {
            $selected_id['driver_id'] = $request->driver_id;
        } else {
            $selected_id['driver_id'] = '';
        }
        if (!empty($request->truck_id)) {
            $selected_id['truck_id'] = $request->truck_id;
        } else {
            $selected_id['truck_id'] = '';
        }
        if (!empty($request->block_id)) {
            $selected_id['block_id'] = $request->block_id;
        } else {
            $selected_id['block_id'] = '';
        }
        if (!empty($request->room_id)) {
            $selected_id['room_id'] = $request->room_id;
        } else {
            $selected_id['room_id'] = '';
        }

        if (!empty($request->net_remaining)) {
            $selected_id['net_remaining'] = $request->net_remaining;
        } else {
            $selected_id['net_remaining'] = '';
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
        $currentProgramId = auth()->user()->program_id;

        $sumNet = Bill::getSumNet($request,  $dbBillType, $currentProgramId);
        $sumNetPayable = Bill::getSumNetPayable($request, $dbBillType, $currentProgramId);
        $sumNetRemaining = Bill::getSumNetRemaining($request, $dbBillType, $currentProgramId);
        $thirdParties = ThirdParty::getThirdPartiesByBillType($type, 'create');
        $paymentType = Payment::getPaymentTypeByBilleType($type);
        return view(
            'bills.index',
            compact(
                'bills',
                'type',
                'page',
                'thirdParties',
                'paymentType',
                'selected_id',
                'dbBillType',
                'sumNet',
                'sumNetPayable',
                'sumNetRemaining'
            )
        );
    }
    public function filterApplied($request)
    {
        $check = array();

        foreach ($request['columns'] as $key => $column) {
            if (!empty($column['search']['value']))
                $check[] = $column['search']['value'];
        }

        if (!empty($request['search']['value']))
            $check[] = $request['search']['value'];

        return sizeof($check);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        if ($type == BillTypeEnum::DeliveryBill) {
            $this->middleware('permission:delivery-bill-create', ['only' => ['create', 'store']]);
        } else {
            $this->middleware('permission:bill-create', ['only' => ['create', 'store']]);
        }


        if ($type == BillTypeEnum::DeliveryBill) {
            $products = Product::where('id', 2)->get();
            $pivots = Pivot::all();
        } else {
            $products = Product::all();
            $pivots = [];
        }
        

        $trucks = Truck::all();
        $blocks = Block::all();
        $parcels = Parcel::all()->where('parcel_category_id', '=', 1);
        $page = Bill::getTitleActivePageByTypeBill($type);
        $rooms = [];
        $thirdParties = ThirdParty::getThirdPartiesByBillType($type, 'create');
        $isSupplier =  ThirdParty::getThirdPartyTypeByBillType($type);
        $isSubcontractor =  ThirdParty::getSubcontractorByBillType($type);

        switch ($type) {
            case BillTypeEnum::EntryBill:
                $dbBillType = BillTypeEnum::EntryBill;
                break;
            case BillTypeEnum::ExitBill:
            case BillTypeEnum::WeighBill:
                $dbBillType = BillTypeEnum::ExitBill;
                break;
            case BillTypeEnum::DamageBill:
                $dbBillType = BillTypeEnum::DamageBill;
                break;
            case BillTypeEnum::DeliveryBill:
                $dbBillType = BillTypeEnum::DeliveryBill;
                break;

            case BillTypeEnum::SubcontractingBill:
                $dbBillType = BillTypeEnum::SubcontractingBill;
                break;
            case BillTypeEnum::OrderBill:
                    $dbBillType = BillTypeEnum::OrderBill;
                    break;    
        }
        $drivers = [];
        if ($type == BillTypeEnum::DeliveryBill || $type == BillTypeEnum::SubcontractingBill) {
            $drivers = Driver::all();
        }
        $nextReference = Setting::getNextReferenceByFieldName($page['fieldParam']);

        return view('bills.create', compact(
            'products',
            'trucks',
            'blocks',
            'isSupplier',
            'dbBillType',
            'drivers',
            'page',
            'type',
            'parcels',
            'rooms',
            'isSubcontractor',
            'thirdParties',
            'nextReference',
            'pivots'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BillRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillRequest $request)
    {

        $type = (int)$request->bill_type;
        $validatedData = Bill::getValidateDataByType($request);

        if ($type == BillTypeEnum::ExitBill || $type == BillTypeEnum::SubcontractingBill) {
            $validatedData['net_remaining'] = $validatedData['net_payable'];
        }
        if ($type == BillTypeEnum::ExitBill) {
            if ($validatedData['number_boxes_returned'] == Null) {
                $validatedData['number_boxes_returned'] = 0;
            }
            if ($validatedData['weight_discount_percentage'] == Null) {
                $validatedData['weight_discount_percentage'] = 0;
            }
            if ($validatedData['discount_value'] == Null) {
                $validatedData['discount_value'] = 0;
            }
            if ($validatedData['net_weight_discount'] == Null) {
                $validatedData['net_weight_discount'] = 0;
            }
        }

        $currentProgramId = auth()->user()->program_id;;
        $validatedData['program_id'] = $currentProgramId;

        if ($bill = Bill::create($validatedData)) {
            $page = Bill::getTitleActivePageByTypeBill($type);
            if ($type == BillTypeEnum::DeliveryBill) {
                $pivotId = $request->pivot_id;
                Setting::setDeliveryBillNextReferenceNumber('delivery_bill', $pivotId);
            } else {
                Setting::setNextReferenceNumber($page['fieldParam']);
            }

            if ($type == BillTypeEnum::ExitBill) {
                $transactionBoxesRequest = new TransactionBoxRequest();
                $params = [
                    'number_boxes_taken' => $request->number_boxes,
                    'number_boxes_returned' => $validatedData['number_boxes_returned'],
                    'transaction_date' => $request->bill_date,
                    'bill_id' => $bill->id,
                    'third_party_id' => $request->third_party_id,
                    'program_id' => $currentProgramId,
                ];
                $transactionBoxesRequest->request->add($params);
                $rules = [
                    'transaction_date' => 'required',
                    'third_party_id' => 'required',
                ];
                //dd($request->all());
                $validator = Validator::make($params, $rules);
                if (!$validator->fails()) {
                    TransactionBox::create($params);
                }
            }
            $displayType = (int)$request->display_type;
            switch ($displayType) {
                case BillTypeEnum::EntryBill:
                    return redirect('/bill/' . BillTypeEnum::EntryBill)->with('message', __('Entry bill successfully created.'));

                case BillTypeEnum::ExitBill:
                    return redirect('/bill/' . BillTypeEnum::ExitBill)->with('message', __('Exit bill successfully created.'));

                case BillTypeEnum::WeighBill:
                    return redirect('/bill/' . BillTypeEnum::WeighBill)->with('message', __('Exit bill successfully created.'));
                case BillTypeEnum::DamageBill:
                    return redirect('/bill/' . BillTypeEnum::DamageBill)->with('message', __('Damage bill successfully created.'));
                case BillTypeEnum::DeliveryBill:
                    return redirect('/bill/' . BillTypeEnum::DeliveryBill)->with('message', __('Delivery bill successfully created.'));
                case BillTypeEnum::SubcontractingBill:
                    return redirect('/bill/' . BillTypeEnum::SubcontractingBill)->with('message', __('Subcontracting bill successfully created.'));
                case BillTypeEnum::OrderBill:
                        return redirect('/bill/' . BillTypeEnum::OrderBill)->with('message', __('Order bill successfully created.'));
                
            
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $type)
    {
        //
        $bill = Bill::findOrFail($id);

        $billPayments = BillPayment::where('bill_id', $id)->get();
        $page = Bill::getTitleActivePageByTypeBill($type);
        return view('bills.show', compact('bill', 'billPayments', 'page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $type)
    {
        if ($type == BillTypeEnum::DeliveryBill) {
            $products = Product::where('id', 2)->pluck('name', 'id');
            $pivots = Pivot::pluck('name', 'id');
        } else {
            $products = Product::pluck('name', 'id');
            $pivots = [];
        }
        if($type == BillTypeEnum::OrderBill){
            $varieties = Variety::pluck('name', 'id');
        }else {
            $varieties = [];
        }

        $trucks = Truck::pluck('registration', 'id');

        $parcels = Parcel::pluck('name', 'id')->where('parcel_category_id', '=', 1);
        $page = Bill::getTitleActivePageByTypeBill($type);

        $thirdParties = ThirdParty::getThirdPartiesByBillType($type, 'edit');

        $isSupplier =  ThirdParty::getThirdPartyTypeByBillType($type);
        $isSubcontractor =  ThirdParty::getSubcontractorByBillType($type);
        $bill = Bill::findOrFail($id);

        $rooms = [];
        $blocks = [];
        $drivers = [];
        $varieties = [];
        if (
            $type != BillTypeEnum::DeliveryBill &&
            $type != BillTypeEnum::SubcontractingBill &&
            $type != BillTypeEnum::OrderBill
        ) {
            $rooms = Room::where('block_id', '=', $bill->block->id)->pluck('name', 'id');
            $blocks = Block::pluck('name', 'id');
        } else {
            $drivers = Driver::pluck('name', 'id');
        }
        if($type == BillTypeEnum::OrderBill){
            
            $varieties = Variety::where('product_id', '=', $bill->product->id)->pluck('name', 'id');
        }
        switch ($type) {
            case BillTypeEnum::EntryBill:
                $dbBillType = BillTypeEnum::EntryBill;
                break;
            case BillTypeEnum::ExitBill:
            case BillTypeEnum::WeighBill:
                $dbBillType = BillTypeEnum::ExitBill;
                break;
            case BillTypeEnum::DamageBill:
                $dbBillType = BillTypeEnum::DamageBill;
                break;
            case BillTypeEnum::DeliveryBill:
                $dbBillType = BillTypeEnum::DeliveryBill;
                break;

            case BillTypeEnum::SubcontractingBill:
                $dbBillType = BillTypeEnum::SubcontractingBill;
                break;
            case BillTypeEnum::OrderBill:
                $dbBillType = BillTypeEnum::OrderBill;
                break;    
        }
        return view('bills.edit', compact(
            'products',
            'trucks',
            'blocks',
            'bill',
            'drivers',
            'isSupplier',
            'page',
            'type',
            'isSubcontractor',
            'pivots',
            'parcels',
            'rooms',
            'varieties',
            'thirdParties',
            'dbBillType'
        )); 
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
        $precedentBill = Bill::findOrFail($id);
        $validatedData = Bill::getValidateDataByType($request);

        //$validatedData['net_remaining']=  $validatedData['net_payable'];


        $type = (int)$request->bill_type;
        if (Bill::whereId($id)->update($validatedData)) {
            if ($type == BillTypeEnum::ExitBill) {
                $transactionBox = TransactionBox::where('bill_id', '=', $id)->get();
                if (!empty($transactionBox[0])) {
                    $params = [
                        'number_boxes_taken' => $request->number_boxes,
                        'number_boxes_returned' => $request->number_boxes_returned,
                        'transaction_date' => $request->bill_date,
                        'bill_id' => $id,
                        'third_party_id' => $request->third_party_id,
                    ];
                    $rules = [
                        'transaction_date' => 'required',
                        'third_party_id' => 'required',
                    ];
                    //dd($request->all());
                    $validator = Validator::make($params, $rules);
                    if (!$validator->fails()) {
                        TransactionBox::whereId($transactionBox[0]->id)->update($params);
                    }
                }
                $actualBill = Bill::findOrFail($id);
                if (($actualBill->net_payable != $precedentBill->net_payable) ||
                    ($actualBill->third_party_id != $precedentBill->third_party_id)
                ) {
                    Bill::where('id', $id)->update(array('net_remaining' => $actualBill->net_payable));
                    BillPayment::where('bill_id', $id)->delete();
                }
            }
            $displayType = (int)$request->display_type;

            switch ($displayType) {
                case BillTypeEnum::EntryBill:
                    return redirect('/bill/' . BillTypeEnum::EntryBill)->with('message', __('Entry bill successfully updated.'));

                case BillTypeEnum::ExitBill:
                    return redirect('/bill/' . BillTypeEnum::ExitBill)->with('message', __('Exit bill successfully updated.'));

                case BillTypeEnum::WeighBill:
                    return redirect('/bill/' . BillTypeEnum::WeighBill)->with('message', __('Exit bill successfully updated.'));

                case BillTypeEnum::DamageBill:
                    return redirect('/bill/' . BillTypeEnum::DamageBill)->with('message', __('Damage bill successfully updated.'));

                case BillTypeEnum::DeliveryBill:
                    return redirect('/bill/' . BillTypeEnum::DeliveryBill)->with('message', __('Delivery bill successfully updated.'));

                case BillTypeEnum::SubcontractingBill:
                    return redirect('/bill/' . BillTypeEnum::SubcontractingBill)->with('message', __('Subcontracting bill successfully updated.'));
           
                case BillTypeEnum::OrderBill:
                    return redirect('/bill/' . BillTypeEnum::OrderBill)->with('message', __('Order bill successfully updated.'));
               
               
         }
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
    public function getRoomsByBlockId($blockId = null)
    {
        $rooms = Room::getRoomsByBlockId($blockId);
        return view('bills.getRoomsByBlockId', compact('rooms'));
    }

    public function getVarietiesByProductId($productId = null)
    {
        $varieties = Variety::getVarietiesByProductId($productId);
        return view('bills.getVarietiesByProductId', compact('varieties'));
    }
    public function getParcelsByThirdPartyId($thirdPartyId = null)
    {
        $parcels = Parcel::getParcelsByThirdPartyId($thirdPartyId);
        return view('bills.getParcelsByThirdPartyId', compact('parcels'));
    }
    public function getSelectByOrigin($origin = null)
    {
        switch ($origin) {
            case 'internal':
                $parcels = Parcel::where('parcel_category_id', 1)->pluck('name', 'id');
                return view('bills.getSelectByOrigin', compact('origin', 'parcels'));

            case 'external':
                $thirdParties = ThirdParty::where('is_supplier', ThirdPartyEnum::Supplier)->pluck('name', 'id');
                return view('bills.getSelectByOrigin', compact('origin', 'thirdParties'));

            default:
                return view('bills.getSelectByOrigin', compact('origin'));
        }
    }

    public function printBill($id, $type)
    {
        $bill = Bill::findOrFail($id);
        $page = Bill::getTitleActivePageByTypeBill($type);
        $billName = __($page['name']) . '-' . $bill->reference;
        $company = Company::first();
        $billPayments = [];

        if ($type == BillTypeEnum::ExitBill) {
            $billPayments = BillPayment::where('bill_id', $id)->get();
        }
        $pdf = PDF::loadView(
            'bills.pdf.printBill',
            compact('bill', 'page', 'billName', 'type', 'company', 'billPayments')
        );

        return $pdf->stream($billName . '.pdf');
    }
    public function print($id)
    {
        return view('bills.getSelectByOrigin');
    }
    public function printSituation(Request $request)
    {

        $bills = DB::table('bills')
            ->join('products as Product', 'Product.id', '=', 'bills.product_id')
            ->join('third_parties as ThirdParty', 'ThirdParty.id', '=', 'bills.third_party_id')

            ->select(
                DB::raw('bills.net_payable - bills.net_remaining as net_paid'),
                'bills.*',
                'Product.name as productName',
                'ThirdParty.name as thirdPartyName'
                //DB::raw("DATE_FORMAT(bills.bill_date, '%d/%m/%Y') as bill_date")
            )
            ->where('bill_type', '=', BillTypeEnum::ExitBill)
            ->where(function ($query) use ($request) {
                return $request->get('third_party_id') ?
                    $query->from('bills')->where('bills.third_party_id', $request->get('third_party_id')) : '';
            })
            ->where(function ($query) use ($request) {
                return $request->get('block_id') ?
                    $query->from('bills')->whereIn('bills.block_id', [$request->get('block_id')]) : '';
            })
            ->where(function ($query) use ($request) {
                return $request->get('room_id') ?
                    $query->from('bills')->whereIn('room_id', [$request->get('room_id')]) : '';
            })
            ->where(function ($query) use ($request) {
                return $request->get('net_remaining') ?
                    $query->from('bills')->where('bills.net_remaining', $request->get('net_remaining'), 0) : '';
            })
            ->where(function ($query) use ($request) {
                return $request->get('date_from') ?
                    $query->from('bills')->where('bill_date', '>=', $request->get('date_from')) : '';
            })
            ->where(function ($query) use ($request) {
                return $request->get('date_to') ?
                    $query->from('bills')->where('bill_date', '<=', $request->get('date_to')) : '';
            })
            ->orderBy("bill_date", "desc")->get();

        $type = $bills[0]->bill_type;

        $billsName = __('Bills situation');
        $company = Company::first();
        $thirdParty = ThirdParty::find($request->third_party_id);

        $pdf = PDF::loadView(
            'bills.pdf.printSituation',
            compact('bills', 'company', 'thirdParty', 'type')
        );

        return $pdf->stream($billsName . '.pdf');
    }
    public function printDetailedSituation(Request $request)
    {

        $bills = DB::table('bills')
            ->join('products as Product', 'Product.id', '=', 'bills.product_id')
            ->join('third_parties as ThirdParty', 'ThirdParty.id', '=', 'bills.third_party_id')

            ->select(
                DB::raw('bills.net_payable - bills.net_remaining as net_paid'),
                'bills.*',
                'Product.name as productName',
                'ThirdParty.name as thirdPartyName'
                //DB::raw("DATE_FORMAT(bills.bill_date, '%d/%m/%Y') as bill_date")
            )
            ->where('bill_type', '=', BillTypeEnum::ExitBill)
            ->where(function ($query) use ($request) {
                return $request->get('third_party_id') ?
                    $query->from('bills')->where('bills.third_party_id', $request->get('third_party_id')) : '';
            })
            ->where(function ($query) use ($request) {
                return $request->get('block_id') ?
                    $query->from('bills')->whereIn('bills.block_id', [$request->get('block_id')]) : '';
            })
            ->where(function ($query) use ($request) {
                return $request->get('room_id') ?
                    $query->from('bills')->whereIn('room_id', [$request->get('room_id')]) : '';
            })
            ->where(function ($query) use ($request) {
                return $request->get('net_remaining') ?
                    $query->from('bills')->where('bills.net_remaining', $request->get('net_remaining'), 0) : '';
            })

            ->where(function ($query) use ($request) {
                return $request->get('date_from') ?
                    $query->from('bills')->where('bill_date', '>=', $request->get('date_from')) : '';
            })
            ->where(function ($query) use ($request) {
                return $request->get('date_to') ?
                    $query->from('bills')->where('bill_date', '<=', $request->get('date_to')) : '';
            })
            ->orderBy("bill_date", "desc")->get();

        $type = $bills[0]->bill_type;

        $billsName = __('Bills situation');
        $company = Company::first();
        $thirdParty = ThirdParty::find($request->third_party_id);

        $pdf = PDF::loadView(
            'bills.pdf.printDetailedSituation',
            compact('bills', 'company', 'thirdParty', 'type')
        )->setPaper('a4', 'landscape');

        return $pdf->stream($billsName . '.pdf');
    }
    public function printDeliveryBill(Request $request)
    {

        $bills = DB::table('bills')
            ->join('products as Product', 'Product.id', '=', 'bills.product_id')
            ->join('third_parties as ThirdParty', 'ThirdParty.id', '=', 'bills.third_party_id')
            ->join('drivers as Driver', 'Driver.id', '=', 'bills.driver_id')
            ->join('trucks as Truck', 'Truck.id', '=', 'bills.truck_id')

            ->select(
                'bills.*',
                'ThirdParty.name as thirdPartyName',
                'Driver.name as driverName',
                'Truck.registration as truckName',
                'Driver.phone as driverPhone'
                //DB::raw("DATE_FORMAT(bills.bill_date, '%d/%m/%Y') as bill_date")
            )
            ->where('bill_type', '=', BillTypeEnum::DeliveryBill)
            ->where(function ($query) use ($request) {
                return $request->get('third_party_id') ?
                    $query->from('bills')->where('bills.third_party_id', $request->get('third_party_id')) : '';
            })

            ->where(function ($query) use ($request) {
                return $request->get('date_from') ?
                    $query->from('bills')->where('bill_date', '>=', $request->get('date_from')) : '';
            })
            ->where(function ($query) use ($request) {
                return $request->get('date_to') ?
                    $query->from('bills')->where('bill_date', '<=', $request->get('date_to')) : '';
            })
            ->orderBy("reference", "desc")->get();

        $billsName = __('bon_livraions');
        $company = Company::first();
        $thirdParty = ThirdParty::find($request->third_party_id);

        $pdf = PDF::loadView(
            'bills.pdf.printSituationDeliveryBill',
            compact('bills', 'company', 'thirdParty')
        );

        return $pdf->stream($billsName . '.pdf');
    }
    public function addPaymentContent()
    {
    }

    public function getDeliveryBillReference(Request $request)
    {
        $pivotId = $request->pivot_id;
        $nextReference = Setting::getDeliveryBillNextReference('delivery_bill', $pivotId);
        return response()->json([
            'reference' => $nextReference
        ]);
    }
}
