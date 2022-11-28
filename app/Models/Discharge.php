<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discharge extends Model
{
    use HasFactory;
    protected $fillable  = ['name','dischage_date','amount'];
    protected $table = 'discharges';
}