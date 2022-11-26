<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentTypeEnum;
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
    protected $fillable  = ['reference','payment_date','payment_type','amount','third_party_id'];
    protected $table = 'payments';

    
    public static function getTitleActivePageByPaymentType($type=null){
        
        $page = [];
         switch ($type){
             case PaymentTypeEnum::Receipt :
                 $activePage= 'bill/'.PaymentTypeEnum::Receipt;
                 $titlePage = 'Add receipt';
                 $namePage = 'Receipt';
                 $titleCard ='Receipts';
                 $fieldParam = 'receipt';
                 break;
             case PaymentTypeEnum::Disbursement :
                 $activePage= 'bill/'.PaymentTypeEnum::Disbursement;
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
}
