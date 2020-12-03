<?php
namespace App\Modules\Bet\Repositories;


use App\Bet;
use App\Modules\Bet\Contracts\BetRepositoryInterface;
use App\Repositories\MainRepository;
use Illuminate\Contracts\Container\Container as App;

class BetRepository extends MainRepository implements BetRepositoryInterface
{
    private $betModel = null;

    public function __construct(App $app,Bet $bet)
    {
        parent::__construct($app);
        $this->betModel = $bet;
    }

    function model()
    {
        return 'App\Bet';
    }
}
