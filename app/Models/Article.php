<?php
namespace App;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function price()
    {
    	return $this->hasOne(Price::class);
    }
    public function color()
    {
    	return $this->hasOne(Color::class);
    }
}
