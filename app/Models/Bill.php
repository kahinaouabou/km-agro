<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BillTypeEnum;
use Carbon\Carbon;

class Bill extends Model
{
    public function Product()
    {
        return $this->belongsTo('App\Models\Product');
    }
    public function Truck()
    {
        return $this->belongsTo('App\Models\Truck');
    }
    public function Parcel()
    {
        return $this->belongsTo('App\Models\Parcel');
    }
    public function ThirdParty()
    {
        return $this->belongsTo('App\Models\ThirdParty');
    }
    public function Block()
    {
        return $this->belongsTo('App\Models\Block');
    }
    public function Room()
    {
        return $this->belongsTo('App\Models\Room');
    }
    public function transactionBoxes()
    {
        return $this->hasMany('App\Models\TransactionBox');
    }
    public function payments()
    {
        return $this->belongsToMany('App\Models\Payment', 'bill_payment');
    }
    protected $fillable  = ['reference','bill_date','bill_type','product_id','truck_id',
                            'origin','parcel_id','third_party_id','block_id','room_id',
                            'number_boxes','raw','tare','net','net_weight_discount',
                            'weight_discount_percentage','unit_price','discount_value',
                            'net_payable','net_remaining','number_boxes_returned'];
    protected $table = 'bills';

    protected $casts  = [

        'type' => BillTypeEnum::class,
        'bill_date' => 'datetime:d/m/Y',
        'weight_discount_percentage' => 0,
        'discount_value' => 0,
        'number_boxes_returned' => 0,

    ];

    public function serializeDate($date){
        if($date != null){
            Carbon::parse($date)->format('Y-m-d');
        }else {
            $date =null;
        }
        
         return $date;
    }
 
    use HasFactory;

   
    /**
     * 
     * @param int $type
     * @return array
     */
    public static function getTitleActivePageByTypeBill($type=null){
        
       $page = [];
        switch ($type){
            case BillTypeEnum::EntryBill :
                $activePage= 'bill/'.BillTypeEnum::EntryBill;
                $titlePage = 'Add entry bill';
                $namePage = 'Entry bill';
                $titleCard ='Entry bills';
                $fieldParam = 'entry_bill';
                break;
            case BillTypeEnum::ExitBill :
                $activePage= 'bill/'.BillTypeEnum::ExitBill;
                $titlePage = 'Add weigh bill';
                $namePage = 'Weigh bill';
                $titleCard = 'Weigh bills';
                $fieldParam = 'weigh_bill';
                break; 
            case BillTypeEnum::WeighBill :
                $activePage= 'bill/'.BillTypeEnum::WeighBill;
                $titlePage = 'Add weigh bill';
                $namePage = 'Weigh bill';
                $titleCard = 'Weigh bills';
                $fieldParam = 'weigh_bill';
                break; 
            case BillTypeEnum::DamageBill :
                    $activePage= 'bill/'.BillTypeEnum::DamageBill;
                    $titlePage = 'Add damage bill';
                    $namePage = 'Damage bill';
                    $titleCard = 'Damage bills';
                    $fieldParam = 'damage_bill';
                    break;          
        }
        $page['active']=$activePage;
        $page['title']=$titlePage;
        $page['name']=$namePage;
        $page['titleCard']=$titleCard;
        $page['fieldParam']=$fieldParam;
        return $page;
    }
    public static function getValidateDataByType($request){
        switch ($request->bill_type){
            case BillTypeEnum::EntryBill :
                $validatedData = $request->validate([
                    'reference' => 'required|min:3',
                    'bill_date' => 'required|min:3',
                    'bill_type'=> 'required',
                    'product_id' => 'required',
                    'truck_id'=> 'required',
                    'block_id'=> 'required',
                    'room_id'=> 'required',
                    'origin'=> 'required',
                    'number_boxes'=> 'required',
                    'raw'=> 'required',
                    'net'=> 'required',
                    'tare'=> 'required',   
                ]);
                break;
            case BillTypeEnum::ExitBill :
                $validatedData = $request->validate([
                    'reference' => 'required|min:3',
                    'bill_date' => 'required|min:3',
                    'bill_type'=> 'required',
                    'product_id' => 'required',
                    'truck_id'=> 'required',
                    'block_id'=> 'required',
                    'room_id'=> 'required',
                    'third_party_id'=> 'required',
                    'number_boxes'=> 'required',
                    'raw'=> 'required',
                    'net'=> 'required',
                    'tare'=> 'required', 
                    'unit_price'=> 'required',
                    'net_payable'=> 'required',
                    'number_boxes_returned' => 'nullable',           
                    'weight_discount_percentage' => 'nullable',
                    'discount_value' => 'nullable',
                    'net_weight_discount' => 'nullable',
                ]);
                break;
                case BillTypeEnum::DamageBill :
                    $validatedData = $request->validate([
                        'reference' => 'required|min:3',
                        'bill_date' => 'required|min:3',
                        'bill_type'=> 'required',
                        'product_id' => 'required',
                        'block_id'=> 'required',
                        'room_id'=> 'required',
                        'origin'=> 'required',
                        'number_boxes'=> 'required',
                        'raw'=> 'required',
                        'net'=> 'required',
                        'tare'=> 'required',   
                    ]);
                    break;
                
            default :
                $validatedData = [];
        }
        return $validatedData ;

    }

    public static function getSumUnstockedQuantityByRoomId($roomId){
        $sumUnstockedQuantity = Bill::where('room_id','=',$roomId)->sum('net');
        return $sumUnstockedQuantity;
    }

    public static function getSumNet($request){
        $sumNet = Bill::
        where( function($query) use($request){
            return $request->get('third_party_id') ?
                   $query->from('bills')->where('third_party_id',$request->get('third_party_id')) : '';})
        ->where( function($query) use($request){
            return $request->get('block_id') ?
                  $query->from('bills')->where('bills.block_id',$request->get('block_id')) : '';})
        ->where( function($query) use($request){
            return $request->get('room_id') ?
                    $query->from('bills')->whereIn('room_id',$request->get('room_id')) : '';})
        ->where( function($query) use($request){
            return $request->get('net_remaining') ?
                    $query->from('bills')->where('bills.net_remaining',$request->get('net_remaining'),0) : '';})                      
                                           
        ->where(function($query) use($request){
            return $request->get('date_from') ?
                  $query->from('bills')->where('bill_date','>=',$request->get('date_from')) : '';})
        ->where(function($query) use($request){
            return $request->get('date_to') ?
                $query->from('bills')->where('bill_date','<=',$request->get('date_to')) : '';}) 
        ->sum("net","net_payable","net_remaining");
        return $sumNet ;

    }
    public static function getSumNetPayable($request){
        $sumNetPayable = Bill::
        where( function($query) use($request){
            return $request->get('third_party_id') ?
                   $query->from('bills')->where('third_party_id',$request->get('third_party_id')) : '';})
        ->where( function($query) use($request){
            return $request->get('block_id') ?
                  $query->from('bills')->where('bills.block_id',$request->get('block_id')) : '';})
        ->where( function($query) use($request){
            return $request->get('room_id') ?
                    $query->from('bills')->whereIn('room_id',$request->get('room_id')) : '';})
        ->where( function($query) use($request){
            return $request->get('net_remaining') ?
                    $query->from('bills')->where('bills.net_remaining',$request->get('net_remaining'),0) : '';})                      
                                           
        ->where(function($query) use($request){
            return $request->get('date_from') ?
                  $query->from('bills')->where('bill_date','>=',$request->get('date_from')) : '';})
        ->where(function($query) use($request){
            return $request->get('date_to') ?
                $query->from('bills')->where('bill_date','<=',$request->get('date_to')) : '';}) 
        ->sum("net_payable","net_remaining");
        return $sumNetPayable ;

    }
    public static function getSumNetRemaining($request){
        $sumNetRemaining = Bill::
        where( function($query) use($request){
            return $request->get('third_party_id') ?
                   $query->from('bills')->where('third_party_id',$request->get('third_party_id')) : '';})
        ->where( function($query) use($request){
            return $request->get('block_id') ?
                  $query->from('bills')->where('bills.block_id',$request->get('block_id')) : '';})
        ->where( function($query) use($request){
            return $request->get('room_id') ?
                    $query->from('bills')->whereIn('room_id',$request->get('room_id')) : '';})
       ->where( function($query) use($request){
            return $request->get('net_remaining') ?
                    $query->from('bills')->where('bills.net_remaining',$request->get('net_remaining'),0) : '';})                      
                                           
        ->where(function($query) use($request){
            return $request->get('date_from') ?
                  $query->from('bills')->where('bill_date','>=',$request->get('date_from')) : '';})
        ->where(function($query) use($request){
            return $request->get('date_to') ?
                $query->from('bills')->where('bill_date','<=',$request->get('date_to')) : '';}) 
        ->sum("net_remaining");
        return $sumNetRemaining ;

    }

   
}
