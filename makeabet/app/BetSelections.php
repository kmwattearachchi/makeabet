<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetSelections extends Model
{
    protected $table  = 'bet_selections';
    protected $fillable = ['selection_id','odds'];
}
