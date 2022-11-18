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
     * @param tinyint $type
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
                break;
            case BillTypeEnum::ExitBill :
                $activePage= 'bill/'.BillTypeEnum::ExitBill;
                $titlePage = 'Add weigh bill';
                $namePage = 'Weigh bill';
                $titleCard = 'Weigh bills';
                break; 
            case BillTypeEnum::WeighBill :
                $activePage= 'bill/'.BillTypeEnum::WeighBill;
                $titlePage = 'Add weigh bill';
                $namePage = 'Weigh bill';
                $titleCard = 'Weigh bills';
                break;     
        }
        $page['active']=$activePage;
        $page['title']=$titlePage;
        $page['name']=$namePage;
        $page['titleCard']=$titleCard;
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
            default :
                $validatedData = [];
        }
        return $validatedData ;

    }

    public static function getSumUnstockedQuantityByRoomId($roomId){
        $sumUnstockedQuantity = Bill::where('room_id','=',$roomId)->sum('net');
        return $sumUnstockedQuantity;
    }

   
}
