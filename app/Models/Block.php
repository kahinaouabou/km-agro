<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Block extends Model
{
    
    public function rooms()
    {
        return $this->hasMany('App\Models\Room');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Models\Warehouse');
    }

    public function bills()
    {
        return $this->hasMany('App\Models\Bill');
    }
    
    protected $fillable  = ['code','name','number_rooms','warehouse_id'];
    protected $table = 'blocks';
    use HasFactory;

    /**
     * @param  int  $warehouseId
     *
     */ 
    public static  function getBlocksByWarehouseId($warehouseId){
        
        $nbBlocks = Block::where('warehouse_id','=',$warehouseId)->count();
        return $nbBlocks;
    }
     /**
     * @param  int  $warehouseId
     *
     */ 
    public static  function checkIfBlockExist($warehouseId){
        $nbBlocks =Block::getBlocksByWarehouseId($warehouseId);
        
        if($nbBlocks>0){
            return true;
        }else {
            return false ;
        }
    }
}
