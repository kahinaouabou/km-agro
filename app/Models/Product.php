<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function bills()
    {
        return $this->hasMany('App\Models\Bill');
    }
    
    protected $fillable  = ['reference','name'];
    protected $table = 'products';
    use HasFactory;
}
