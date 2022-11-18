<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Room extends Model
{
    public function block()
    {
        return $this->belongsTo('App\Models\Block');
    }

    public function bills()
    {
        return $this->hasMany('App\Models\Bill');
    }
    
    protected $fillable  = ['code','name','length','width','height','volume','block_id',
                    'stored_quantity','unstocked_quantity','damaged_quantity','weightloss_value','loss_value','loss_percentage'];
    protected $table = 'rooms';
    
    use HasFactory;
    /**
     * @param  int  $blockId
     *
     */ 
    public static  function getCountRoomsByBlockId($blockId){
        
        $nbRooms = Room::where('block_id','=',$blockId)->count();
        return $nbRooms;
    }
   
     /**
     * @param  int  $blockId
     *
     */ 
    public static  function checkIfRoomExist($blockId){
        $nbRooms =Room::getCountRoomsByBlockId($blockId);
        
        if($nbRooms>0){
            return true;
        }else {
            return false ;
        }
    }

    public static function getRoomsByBlockId($blockId){
        $rooms = Room::where('block_id',$blockId)->pluck('name', 'id');
        return $rooms;
    }

    
}
