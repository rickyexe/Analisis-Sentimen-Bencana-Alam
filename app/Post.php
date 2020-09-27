<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table= 'training_data';
    public $timestamps = false;

    protected $fillable = [
        'post'
    ];
}
