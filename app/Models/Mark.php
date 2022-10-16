<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    public function trucks()
    {
        return $this->hasMany('App\Models\Truck');
    }

    protected $fillable  = ['code','name'];
    protected $table = 'marks';
    
    use HasFactory;

      /**
     * @param  int  $markId
     *
     */ 
    public static  function getTrucksByMarkId($markId){
        
        $nbTrucks = Mark::where('mark_id','=',$markId)->count();
        return $nbTrucks;
    }
     /**
     * @param  int  $markId
     *
     */ 
    public static  function checkIfMarkExist($markId){
        $nbTrucks =Mark::getTrucksByMarkId($markId);
        
        if($nbTrucks>0){
            return true;
        }else {
            return false ;
        }
    }
}
