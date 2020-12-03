<?php
namespace App\Modules\Balancetransaction\Repositories;

use App\BalanceTransaction;
use App\Modules\Balancetransaction\Contracts\BalanceTransactionRepositoryInterface;
use App\Repositories\MainRepository;
use Illuminate\Contracts\Container\Container as App;

class BalanceTransactionRepository extends MainRepository implements BalanceTransactionRepositoryInterface
{
    private $balanceTransactionModel = null;

    public function __construct(App $app,BalanceTransaction $balanceTransaction)
    {
        parent::__construct($app);
        $this->balanceTransactionModel = $balanceTransaction;
    }

    function model()
    {
        return 'App\BalanceTransaction';
    }
}
