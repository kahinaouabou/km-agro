<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    public function ParcelCategory()
    {
        return $this->belongsTo('App\Models\ParcelCategory');
    }

    public function ThirdParty()
    {
        return $this->belongsTo('App\Models\ThirdParty');
    }

    public function bills()
    {
        return $this->hasMany('App\Models\Bill');
    }
    
    protected $fillable  = ['code','name','address','parcel_category_id','third_party_id'];
    protected $table = 'parcels';
    use HasFactory;

     /**
     * @param  int  $parcelCategoryId
     *
     */ 
    public static  function getCountParcelsByParcelCategoryId($parcelCategoryId){
        
        $nbParcels = Parcel::where('parcel_category_id','=',$parcelCategoryId)->count();
        return $nbParcels;
    }
     /**
     * @param  int  $parcelCategoryId
     *
     */ 
    public static  function checkIfParcelExist($parcelCategoryId){
        $nbParcels =Parcel::getCountParcelsByParcelCategoryId($parcelCategoryId);
        
        if($nbParcels>0){
            return true;
        }else {
            return false ;
        }
    }

    public static function getParcelsByThirdPartyId($thirdPartyId){
        $parcels = Parcel::where('third_party_id',$thirdPartyId)->pluck('name', 'id');
        return $parcels;
    }
}
