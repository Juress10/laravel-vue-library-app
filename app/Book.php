<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $table = 'books';
    protected $primaryKey = 'id';
    protected $fillable = ['id','title','is_borrowed'];

    public function author()
    {
        return $this->belongsTo('App\Author');
    }
}
