<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table  = 'player';
    protected $fillable = ['id','balance'];
}