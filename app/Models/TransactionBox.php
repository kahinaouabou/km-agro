<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionBox extends Model
{
    public function thirdParty()
    {
        return $this->belongsTo('App\Models\ThirdParty');
    }
    public function bill()
    {
        return $this->belongsTo('App\Models\Bill');
    }

    public function Program()
    {
        return $this->belongsTo('App\Models\Program');
    }
    
    protected $fillable  = ['transaction_date','number_boxes_returned',
    'number_boxes_taken','bill_id','third_party_id','program_id'];
    protected $table = 'transaction_boxes';
    protected $casts  = [
        'transaction_date' => 'datetime',

    ];
    use HasFactory;
}
