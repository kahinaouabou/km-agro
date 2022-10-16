<?php

namespace App\Models;
use App\Enums\BillTypeEnum;
use App\Enums\ThirdPartyEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThirdParty extends Model
{
    public function parcels()
    {
        return $this->hasMany('App\Models\Parcel');
    }
    public function bills()
    {
        return $this->hasMany('App\Models\Bill');
    }
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }
    public function transactionBoxes()
    {
        return $this->hasMany('App\Models\TransactionBox');
    } 

    public static function getThirdPartiesByBillType($billType){
        $thirdParties = [];
        switch ($billType) {
                case BillTypeEnum::EntryBill :
                    $thirdParties = ThirdParty::all()->where('is_supplier','=',ThirdPartyEnum::Supplier);
                    break;
                case BillTypeEnum::ExitBill :
                    $thirdParties = ThirdParty::all()->where('is_supplier','=',ThirdPartyEnum::Customer); 
                    break;    
        }
        return $thirdParties;

    }
    public static function getThirdPartiesByType($type){
       
       
        $thirdParties = ThirdParty::all()->where('is_supplier','=',$type); 
       
        return $thirdParties;

    }
    protected $fillable  = ['code','name','address','is_supplier'];
    protected $table = 'third_parties';
    
    use HasFactory;
}
