<?php

namespace App\Http\Controllers;
use App\Models\Bill;
use App\Models\Product;
use App\Models\Truck;
use App\Models\Block;
use App\Models\Room;
use App\Models\Parcel;
use App\Models\ThirdParty;
use App\Models\BillPayment;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\BillRequest;
use App\Enums\BillTypeEnum;
use App\Enums\ThirdPartyEnum;
use App\Http\Requests\TransactionBoxRequest;
use App\Models\TransactionBox;
use PDF;
use Illuminate\Support\Facades\Date;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\DB;
class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
         * @param tinyint $type
     * @return \Illuminate\Http\Response
     */
    public function index($type, Request $request)
    {
        //
        $bills = Bill::where('bill_type', $type)->paginate(15);
        
        //and create a view which we return - note dot syntax to go into folder
        switch ($type){
            case BillTypeEnum::EntryBill:
                $dbBillType = BillTypeEnum::EntryBill;
            break;
            case BillTypeEnum::ExitBill : 
            case BillTypeEnum::WeighBill:
                $dbBillType = BillTypeEnum::ExitBill;
            break ;    
        }  
        if ($request->ajax()) {
            $limit = request('length');
            $start = request('start');
            $data = DB::table('bills')
                ->join('products as Product', 'Product.id', '=', 'bills.product_id')
                ->join('third_parties as ThirdParty', 'ThirdParty.id', '=', 'bills.third_party_id')     
                ->join('blocks as Block', 'Block.id', '=', 'bills.block_id')     
                ->join('rooms as Room', 'Room.id', '=', 'bills.room_id')     
                ->join('trucks as Truck', 'Truck.id', '=', 'bills.truck_id')     
                ->select(
                DB::raw('bills.net_payable - bills.net_remaining as net_paid')  , 
                'bills.*', 
                'Product.name as productName',
                'Block.name as blockName',
                'Room.name as roomName',
                'Truck.registration as truckName',
                'ThirdParty.name as thirdPartyName')
               // DB::raw("DATE_FORMAT(bills.bill_date, '%d/%m/%Y') as bill_date") )
                ->where('bill_type', '=', $dbBillType)
                ->where( function($query) use($request){
                    return $request->get('third_party_id') ?
                           $query->from('bills')->where('third_party_id',$request->get('third_party_id')) : '';})
                ->where(function($query) use($request){
                    return $request->get('date_from') ?
                          $query->from('bills')->where('bill_date','>=',$request->get('date_from')) : '';})
                ->where(function($query) use($request){
                    return $request->get('date_to') ?
                        $query->from('bills')->where('bill_date','<=',$request->get('date_to')) : '';}) 
                ->orderBy("bill_date","desc") ; 
                $columns = $request['columns'];
                    
                $count = $data->count();    
                $data = $data->offset($start)->limit($limit);
                return Datatables::of($data)
                
                ->setTotalRecords($count)
                    ->addIndexColumn()
                    ->editColumn('raw', function($row) {
                        return number_format($row->raw, 0, ',', ' ');
                    })
                    ->editColumn('tare', function($row) {
                        return number_format($row->raw, 0, ',', ' ');
                    })
                    ->editColumn('net', function($row) {
                        return number_format($row->raw, 0, ',', ' ');
                    })
                    ->editColumn('number_boxes', function($row) {
                        return number_format($row->number_boxes, 0, ',', ' ');
                    })
                    ->editColumn('net_payable', function($row) {
                        return number_format($row->number_boxes, 2, ',', ' ');
                    })
                    ->editColumn('net_remaining', function($row) {
                        return number_format($row->net_remaining, 2, ',', ' ');
                    })
                    ->editColumn('net_paid', function($row) {
                        return number_format($row->net_paid, 2, ',', ' ');
                    })
                    ->addColumn('action', function($row) use ($type){
                        $routeEdit =  route("bills.edit", [$row->id,$row->bill_type]) ;
                        $routeDelete = route("bills.destroy", $row->id);
                        $routePrint = route("bills.printBill", [$row->id,$type ]);
                        $idDestroy = "destroy".$row->id;
                        $btn ='<a rel="tooltip" class="btn btn-action btn-success btn-link edit-bill-button" href='.$routeEdit.' data-original-title="" title="">
                        <i class="material-icons">edit</i>
                        <div class="ripple-container"></div>
                            </a>
                            <a rel="tooltip" class="btn btn-action btn-warning btn-link" href='.$routePrint.' data-original-title="" title="" target="_blank">
                        <i class="material-icons">print</i>
                        <div class="ripple-container"></div>
                            </a>
                        <a rel="tooltip" class="btn btn-action btn-danger btn-link"
                        onclick="event.preventDefault(); document.getElementById('.$idDestroy.').submit();" data-original-title="" title="">
                        <i class="material-icons">delete</i>
                            <div class="ripple-container"></div>  
                            </a>
                            <form id='.$idDestroy.' action='.$routeDelete.' method="POST" style="display: none;">
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
        $selected_id['third_party_id'] = $request->third_party_id;
        $selected_id['date_from'] = $request->date_from;
        $selected_id['date_to'] = $request->date_to;
      
        return view('bills.index',compact('bills','type','page','selected_id','dbBillType'));
   
    }
    public function filterApplied($request) {
        $check = array();
    
        foreach($request['columns'] as $key => $column) {
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
        
        $products = Product::all();
        $trucks = Truck::all();
        $blocks = Block::all();
        $parcels = Parcel::all()->where('parcel_category_id','=',1);
        $page = Bill::getTitleActivePageByTypeBill($type);
        $rooms =[];
        $thirdParties = ThirdParty:: getThirdPartiesByBillType($type,'create');
        $isSupplier =  ThirdParty:: getThirdPartyTypeByBillType($type);
        return view('bills.create', compact('products','trucks','blocks','isSupplier',
                                    'page','type','parcels','rooms','thirdParties'));
    }

    /**
     * Store a newly created resource in storage.
     *
      * @param  \Illuminate\Http\BillRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillRequest $request)
    {
        $request->net_remaining = $request->net_payable;
        $validatedData = Bill::getValidateDataByType($request);
        $validatedData['net_remaining']=  $validatedData['net_payable'];
        if($validatedData['number_boxes_returned']==Null){
            $validatedData['number_boxes_returned']=0; 
        }
        if($validatedData['weight_discount_percentage']==Null){
            $validatedData['weight_discount_percentage']=0; 
        }
        if($validatedData['discount_value']==Null){
            $validatedData['discount_value']=0; 
        }
        if($validatedData['net_weight_discount']==Null){
            $validatedData['net_weight_discount']=0; 
        }
        
        //dd($request);
        $type = (int)$request->bill_type ;
        if($bill= Bill::create($validatedData)){
            if($type==BillTypeEnum::ExitBill){
                $transactionBoxesRequest = new TransactionBoxRequest();
                $params = [
                    'number_boxes_taken' => $request->number_boxes,
                    'number_boxes_returned' => $validatedData['number_boxes_returned'],
                    'transaction_date' => $request->bill_date,
                    'bill_id' => $bill->id,
                    'third_party_id' => $request->third_party_id,
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
            switch ($type){
                case BillTypeEnum::EntryBill :
                    return redirect('/bill/'.BillTypeEnum::EntryBill)->with('message',__('Entry bill successfully created.'));
                    break;
                case BillTypeEnum::ExitBill :
                    return redirect('/bill/'.BillTypeEnum::ExitBill)->with('message',__('Exit bill successfully created.'));
                    break; 
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $type)
    {
        $products = Product::pluck('name', 'id');
        $trucks = Truck::pluck('registration', 'id');
        $blocks = Block::pluck('name', 'id');
        $parcels = Parcel::pluck('name', 'id')->where('parcel_category_id','=',1);
        $page = Bill::getTitleActivePageByTypeBill($type);
        
        $thirdParties = ThirdParty:: getThirdPartiesByBillType($type, 'edit');
        $isSupplier =  ThirdParty:: getThirdPartyTypeByBillType($type);
        $bill = Bill::findOrFail($id);
        $rooms =Room::where('block_id','=',$bill->block->id)->pluck('name', 'id');
        return view('bills.edit', compact('products','trucks','blocks','bill','isSupplier',
                                    'page','type','parcels','rooms','thirdParties'));
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
        $request->net_remaining = $request->net_payable;
        $validatedData = Bill::getValidateDataByType($request);
        $validatedData['net_remaining']=  $validatedData['net_payable'];
        
        
        $type = (int)$request->bill_type ;
        if($bill=Bill::whereId($id)->update($validatedData)){
            if($type==BillTypeEnum::ExitBill){
                $transactionBox = TransactionBox::where('bill_id','=',$id)->get();
                if(!empty($transactionBox[0])){
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
                if(($actualBill->net_payable != $precedentBill->net_payable) ||
                ($actualBill->third_party_id != $precedentBill->third_party_id)
                    ){
                        Bill::where('id', $id)->update(array('net_remaining' => $bill->net_payable));
                        BillPayment::where('bill_id', $id)->delete();
                    }
                
                
            }
            switch ($type){
                case BillTypeEnum::EntryBill :
                    return redirect('/bill/'.BillTypeEnum::EntryBill)->with('message',__('Entry bill successfully updated.'));
                    break;
                case BillTypeEnum::ExitBill :
                    return redirect('/bill/'.BillTypeEnum::ExitBill)->with('message',__('Exit bill successfully updated.'));
                    break; 
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
    public function getRoomsByBlockId($blockId =null){
        $rooms = Room::getRoomsByBlockId($blockId);
        return view('bills.getRoomsByBlockId', compact('rooms'));
    }
    public function getParcelsByThirdPartyId($thirdPartyId =null){
        $parcels = Parcel::getParcelsByThirdPartyId($thirdPartyId);
        return view('bills.getParcelsByThirdPartyId', compact('parcels'));
    }
    public function getSelectByOrigin($origin=null){
        switch($origin){
            case 'internal':
                $parcels = Parcel::where('parcel_category_id',1)->pluck('name', 'id');
                return view('bills.getSelectByOrigin', compact('origin','parcels'));
                break;
            case 'external' :
                $thirdParties = ThirdParty::where('is_supplier',ThirdPartyEnum::Supplier)->pluck('name', 'id');
                return view('bills.getSelectByOrigin', compact('origin','thirdParties'));
                break; 
             default:
             return view('bills.getSelectByOrigin', compact('origin'));      
        }
        
    }

    public function printBill($id,$type){
        $bill = Bill::findOrFail($id);
        $page = Bill::getTitleActivePageByTypeBill($type);
        $billName = __($page['name']).'-'.$bill->reference;
        $company = Company::first();
        $pdf = PDF::loadView('bills.pdf.printBill', 
        compact('bill','page','billName','type','company'));
        return $pdf->download($billName.'.pdf');
    }
    public function print($id){
        return view('bills.getSelectByOrigin'); 
    }
    public function addPaymentContent(){

    }
}
