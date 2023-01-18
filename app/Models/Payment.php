<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentTypeEnum;
use App\Enums\BillTypeEnum;
use Carbon\Carbon;
class Payment extends Model
{
    public function bills()
    {
        return $this->belongsToMany('App\Models\Bill', 'bill_payment');
    }
    public function ThirdParty()
    {
        return $this->belongsTo('App\Models\ThirdParty');
    }
    public function PaymentCategory()
    {
        return $this->belongsTo('App\Models\PaymentCategory');
    }
    
    protected $casts  = [
        'payment_date' => 'date:d/m/Y',

    ];
 
    
    use HasFactory;

    public function serializeDate($date){
        if($date != null){
            Carbon::parse($date)->format('Y-m-d');
        }else {
            $date =null;
        }
        
         return $date;
    }
    protected $fillable  = ['reference','payment_date','payment_type',
    'amount','third_party_id','program_id','observation'];
    protected $table = 'payments';

    
    public static function getTitleActivePageByPaymentType($type=null){
        
        $page = [];
         switch ($type){
             case PaymentTypeEnum::Receipt :
                 $activePage= 'payment/'.PaymentTypeEnum::Receipt;
                 $titlePage = 'Add receipt';
                 $namePage = 'Receipt';
                 $titleCard ='Receipts';
                 $fieldParam = 'receipt';
                 break;
             case PaymentTypeEnum::Disbursement :
                 $activePage= 'payment/'.PaymentTypeEnum::Disbursement;
                 $titlePage = 'Add disbursement';
                 $namePage = 'Disbursement';
                 $titleCard = 'Disbursements';
                 $fieldParam = 'disbursement';
                 break;          
         }
         $page['active']=$activePage;
         $page['title']=$titlePage;
         $page['name']=$namePage;
         $page['titleCard']=$titleCard;
         $page['fieldParam']=$fieldParam;
         return $page;
     }
     public static function getSumAmounts($request, $type, $currentProgramId){
        $sumAmounts = Payment::
             where('payment_type', '=', $type)
            ->where('program_id', '=', $currentProgramId)
            ->where( function($query) use($request){
                return $request->get('third_party_id') ?
                       $query->from('payments')->where('third_party_id',$request->get('third_party_id')) : '';})
            ->where( function($query) use($request){
                return $request->get('payment_type') ?
                    $query->from('payments')->where('payment_type',$request->get('payment_type')) : '';})
            ->where(function($query) use($request){
                return $request->get('date_from') ?
                      $query->from('payments')->where('payment_date','>=',$request->get('date_from')) : '';})
            ->where(function($query) use($request){
                return $request->get('date_to') ?
                    $query->from('payments')->where('payment_date','<=',$request->get('date_to')) : '';})
            ->sum('amount');
        return $sumAmounts;  

     }

        
     public static function getPaymentTypeByBilleType($billType){
        switch ($billType) {
            case BillTypeEnum::ExitBill :
            case BillTypeEnum::WeighBill: 
            case BillTypeEnum::DamageBill:        
                $paymentType = PaymentTypeEnum::Receipt; 
                break; 
            case BillTypeEnum::SubcontractingBill:    
            case BillTypeEnum::DeliveryBill:     
                $paymentType=PaymentTypeEnum::Disbursement; 
                break;         
            }
    return $paymentType;
     }
   
}
