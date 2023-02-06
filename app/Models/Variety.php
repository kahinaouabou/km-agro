<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    use HasFactory;
    protected $fillable = ['name','product_id'];
    public function Product()
    {
        return $this->belongsTo('App\Models\Product');
    }
    public function bills()
    {
        return $this->hasMany('App\Models\Bill');
    }

    public static function getVarietiesByProductId($productId){
        $varieties = Variety::where('product_id',$productId)->pluck('name', 'id');
        return $varieties;
    }
}
