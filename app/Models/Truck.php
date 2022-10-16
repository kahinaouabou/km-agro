<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    public function mark()
    {
        return $this->belongsTo('App\Models\Mark');
    }
    public function bills()
    {
        return $this->hasMany('App\Models\Bill');
    }
    
    protected $fillable  = ['registration','model','mark_id','tare'];
    protected $table = 'trucks';
    use HasFactory;
}
