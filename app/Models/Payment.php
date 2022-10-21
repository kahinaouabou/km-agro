<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
