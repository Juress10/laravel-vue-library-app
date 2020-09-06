<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public $table = 'authors';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name','surname'];


    public function books()
    {
        return $this->hasMany('App\Book');
    }
}
