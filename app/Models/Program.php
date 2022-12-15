<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Program extends Model
{
    public function bills()
    {
        return $this->hasMany('App\Models\Bill');
    }
    public function transactionBoxes()
    {
        return $this->hasMany('App\Models\TransactionBox');
    }
    
    protected $fillable  = ['code','name','is_current'];
    
    use HasFactory;

    public static function getCurrentProgram(){
        $program = Program::where('is_current',1)->first();
        
        return $program->id;
    }
}
