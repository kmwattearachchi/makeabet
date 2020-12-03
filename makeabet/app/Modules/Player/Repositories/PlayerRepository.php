<?php
namespace App\Modules\Player\Repositories;


use App\Modules\Player\Contracts\PlayerRepositoryInterface;
use App\Player;
use App\Repositories\MainRepository;
use Illuminate\Contracts\Container\Container as App;

class PlayerRepository extends MainRepository implements PlayerRepositoryInterface
{
    private $playerModel = null;

    public function __construct(App $app,Player $player)
    {
        parent::__construct($app);
        $this->playerModel = $player;
    }

    function model()
    {
        return 'App\Player';
    }
}
