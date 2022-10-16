<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelCategory extends Model
{
    public function parcels()
    {
        return $this->hasMany('App\Models\Parcel');
    }
    protected $fillable  = ['code','name'];
    protected $table = 'parcel_categories';
    use HasFactory;
}
