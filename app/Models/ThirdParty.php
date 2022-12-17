<?php

namespace App\Models;
use App\Enums\BillTypeEnum;
use App\Enums\ThirdPartyEnum;
use App\Enums\SubcontractorEnum;
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
    public function drivers()
    {
        return $this->hasMany('App\Models\Driver');
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
                    case BillTypeEnum::DeliveryBill :
                            $thirdParties = ThirdParty::all()
                            ->where('is_supplier','=',ThirdPartyEnum::Supplier)
                            ->where('is_subcontractor','=',SubcontractorEnum::Subcontractor);
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
                    case BillTypeEnum::DeliveryBill :
                            $thirdParties = ThirdParty::pluck('name', 'id')
                            ->where('is_supplier','=',ThirdPartyEnum::Supplier)
                            ->where('is_subcontractor','=',SubcontractorEnum::Subcontractor);
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
                case BillTypeEnum::DeliveryBill :    
                    $isSupplier = ThirdPartyEnum::Supplier;
                    break;
                case BillTypeEnum::ExitBill :
                case BillTypeEnum::WeighBill:    
                    $isSupplier=ThirdPartyEnum::Customer; 
                    break;    
        }
        return $isSupplier;
    }

    public static function getSubcontractorByBillType($billType){
        $isSubcontractor =null;
        switch ($billType) {
                case BillTypeEnum::EntryBill :
                case BillTypeEnum::DeliveryBill :    
                    $isSubcontractor = SubcontractorEnum::Subcontractor;
                    break;
                case BillTypeEnum::ExitBill :
                case BillTypeEnum::WeighBill:    
                    $isSubcontractor=SubcontractorEnum::Supplier; 
                    break;    
        }
        return $isSubcontractor;
    }
    public static function getThirdPartiesByType($type){
       
       
        $thirdParties = ThirdParty::all()->where('is_supplier','=',$type); 
       
        return $thirdParties;

    }

    public static function getTitleActivePageByThirdPartyType($isSupplier, $isSubcontractor){
        if($isSupplier==1)  { 
            if($isSubcontractor == 0) {
                $activePage= 'thirdParty/1/0';
                $titlePage = 'Suppliers';
            } else {
                $activePage = 'thirdParty/1/1';
                $titlePage =  'Subcontractors' ;
            } 
        } else {
                $activePage = 'thirdParty/0/0';
                $titlePage =  'Customers' ;   
            }
        $page['active'] = $activePage;
        $page['title'] = $titlePage;
        return $page;
         
    }
    protected $fillable  = ['code','name','address','phone','is_supplier','is_subcontractor'];
    protected $table = 'third_parties';
    
    use HasFactory;
}
