<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    public function blocks()
    {
        return $this->hasMany('App\Models\Block');
    } 
    protected $fillable  = ['code','name','address'];
    protected $table = 'warehouses';
    use HasFactory;
}
