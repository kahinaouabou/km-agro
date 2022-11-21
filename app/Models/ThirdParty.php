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

    public static function getThirdPartiesByBillType($billType, $action){
        $thirdParties = [];
        switch ($action) {
            case 'create':
                switch ($billType) {
                    case BillTypeEnum::EntryBill :
                        $thirdParties = ThirdParty::all()->where('is_supplier','=',ThirdPartyEnum::Supplier);
                        break;
                    case BillTypeEnum::ExitBill :
                    case BillTypeEnum::WeighBill:
                        $thirdParties = ThirdParty::all()->where('is_supplier','=',ThirdPartyEnum::Customer); 
                        break;
                    default    :
                    $thirdParties = [];    
                }
            break;
            case 'edit':
                switch ($billType) {
                    case BillTypeEnum::EntryBill :
                        $thirdParties = ThirdParty::pluck('name', 'id')->where('is_supplier','=',ThirdPartyEnum::Supplier);
                        break;
                    case BillTypeEnum::ExitBill :
                    case BillTypeEnum::WeighBill:    
                        $thirdParties = ThirdParty::pluck('name', 'id')->where('is_supplier','=',ThirdPartyEnum::Customer); 
                        break;  
                        default    :
                        $thirdParties = [];      
                }
            break ;   

        }
       
        return $thirdParties;

    }
    public static function getThirdPartyTypeByBillType($billType){
        
        $isSupplier =null;
        switch ($billType) {
                case BillTypeEnum::EntryBill :
                    $isSupplier = ThirdPartyEnum::Supplier;
                    break;
                case BillTypeEnum::ExitBill :
                case BillTypeEnum::WeighBill:    
                    $isSupplier=ThirdPartyEnum::Customer; 
                    break;    
        }
        return $isSupplier;
    }
    public static function getThirdPartiesByType($type){
       
       
        $thirdParties = ThirdParty::all()->where('is_supplier','=',$type); 
       
        return $thirdParties;

    }
    protected $fillable  = ['code','name','address','phone','is_supplier'];
    protected $table = 'third_parties';
    
    use HasFactory;
}
