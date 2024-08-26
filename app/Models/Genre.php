<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    protected $table='genres';
    protected $fillable=['nama'];

    public function movie(){
        return $this->hasMany(Movie::class,'genre_id','id');
    }
}
