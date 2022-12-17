<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function ThirdParty()
    {
        return $this->belongsTo('App\Models\ThirdParty');
    }
    public function bills()
    {
        return $this->hasMany('App\Models\Bill');
    }
    use HasFactory;
    protected $fillable  = ['name','phone','third_party_id'];
}
