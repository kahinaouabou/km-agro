<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pivot extends Model
{
    use HasFactory;
    protected $fillable  = ['delivery_bill_prefix','name'];

    static public function getReferenceInfosByPivotId($pivotId){
        $pivot = Pivot::where('id', $pivotId)->first();
        return $pivot;
    }
}
