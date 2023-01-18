<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCategory extends Model
{
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }
    protected $fillable  = ['name'];
    use HasFactory;
}
