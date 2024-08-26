<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $table='movies';
    protected $fillable=['title','sinopsis','rilis','genre_id'];
    //dengan $hidden maka kolom genre_id tidak akan ditampilkan
    protected $hidden=['genre_id'];

    public function genre(){
        return $this->belongsTo(Genre::class,'genre_id','id');
    }
}
