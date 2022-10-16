<?php

namespace App\Http\Controllers;
use App\Models\Bill;
use App\Models\Product;
use App\Models\Truck;
use App\Models\Block;
use App\Models\Room;
use App\Models\Parcel;
use App\Models\ThirdParty;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\BillRequest;
use App\Enums\BillTypeEnum;
use App\Enums\ThirdPartyEnum;
use App\Http\Requests\TransactionBoxRequest;
use App\Models\TransactionBox;
use PDF;
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
          

            $data = DB::table('bills')
                ->join('products as Product', 'Product.id', '=', 'bills.product_id')
                ->join('third_parties as ThirdParty', 'ThirdParty.id', '=', 'bills.third_party_id')     
                ->join('blocks as Block', 'Block.id', '=', 'bills.block_id')     
                ->join('rooms as Room', 'Room.id', '=', 'bills.room_id')     
                ->join('trucks as Truck', 'Truck.id', '=', 'bills.truck_id')     
                ->select('bills.*', 
                'Product.name as productName',
                'Block.name as blockName',
                'Room.name as roomName',
                'Truck.model as truckName',
                'ThirdParty.name as thirdPartyName',
                DB::raw("DATE_FORMAT(bills.bill_date, '%d/%m/%Y') as bill_date"))
                ->where('bill_type', '=', $dbBillType)
                ->where( function($query) use($request){
                    return $request->get('third_party_id') ?
                           $query->from('bills')->where('third_party_id',$request->get('third_party_id')) : '';})
                ->where(function($query) use($request){
                    return $request->get('date_from') ?
                          $query->from('bills')->where('bill_date','>=',$request->get('date_from')) : '';})
                ->where(function($query) use($request){
                    return $request->get('date_to') ?
                        $query->from('bills')->where('bill_date','<=',$request->get('date_to')) : '';});   
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) use ($type){
                        $routeEdit =  route("bills.edit", [$row->id,$row->bill_type]) ;
                        $routeDelete = route("bills.destroy", $row->id);
                        $routePrint = route("bills.printBill", [$row->id,$type ]);
                        $idDestroy = "destroy".$row->id;
                        $btn ='<a rel="tooltip" class="btn btn-success btn-link" href='.$routeEdit.' data-original-title="" title="">
                        <i class="material-icons">edit</i>
                        <div class="ripple-container"></div>
                            </a>
                            <a rel="tooltip" class="btn btn-warning btn-link" href='.$routePrint.' data-original-title="" title="" target="_blank">
                        <i class="material-icons">print</i>
                        <div class="ripple-container"></div>
                            </a>
                        <a rel="tooltip" class="btn btn-danger btn-link"
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
        $thirdParties = ThirdParty:: getThirdPartiesByBillType($type);
        return view('bills.create', compact('products','trucks','blocks',
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
        
        //dd($request);
        $type = (int)$request->bill_type ;
        if($bill= Bill::create($validatedData)){
            if($type==BillTypeEnum::ExitBill){
                $transactionBoxesRequest = new TransactionBoxRequest();
                $params = [
                    'number_boxes_taken' => $request->number_boxes,
                    'number_boxes_returned' => $request->number_boxes_returned,
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
        $products = Product::all();
        $trucks = Truck::all();
        $blocks = Block::all();
        $parcels = Parcel::all()->where('parcel_category_id','=',1);
        $page = Bill::getTitleActivePageByTypeBill($type);
        $rooms =[];
        $thirdParties = ThirdParty:: getThirdPartiesByBillType($type);
        $bill = Bill::findOrFail($id);
        return view('bills.edit', compact('products','trucks','blocks','bill',
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
