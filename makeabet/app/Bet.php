<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $table  = 'bet';
    protected $fillable = ['stake_amount'];
    protected $with = ['betSelections'];

    public function betSelections()
    {
        return $this->hasMany('App\BetSelections','bet_id','id');
    }
}
