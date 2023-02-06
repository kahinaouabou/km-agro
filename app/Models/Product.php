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
    public function varieties()
    {
        return $this->hasMany('App\Models\Variety');
    }
    
    protected $fillable  = ['reference','name'];
    protected $table = 'products';
    use HasFactory;
}
