<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
class BillPayment extends Model
{
    
    public function Bill()
    {
        return $this->belongsTo('App\Models\Bill');
    }
    public function Payment()
    {
        return $this->belongsTo('App\Models\Payment');
    }
    protected $fillable  = ['bill_id','payment_id', 'amount_paid'];
    protected $table = 'bill_payment';
    use HasFactory;
    public static function insertBillPayment($params){
        $created = false ; 
        $rules = [
            'bill_id' => 'required',
            'payment_id' => 'required',
            'amount_paid' => 'required'
        ];
          //dd($request->all());
          $validator = Validator::make($params, $rules);
          
          if (!$validator->fails()) {
            if(BillPayment::create($params)){
                $created = true;
            };
          }
          return $created;
    }
}
