<?php

namespace App\Modules\Bet\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Balancetransaction\Contracts\BalanceTransactionRepositoryInterface;
use App\Modules\Bet\Contracts\BetRepositoryInterface;
use App\Modules\Bet\Http\Requests\NewBetRequest;
use App\Modules\Player\Contracts\PlayerRepositoryInterface;
use Illuminate\Support\Facades\DB;


/**
 * Class BetController
 * @package App\Modules\Bet\Http\Controllers
 */
class BetController extends Controller
{
    private $apiResponseCode = API_RES_STATUS_SUCCESS;
    private $response = [];
    private $betRepository;
    private $playerRepository;
    private $balanceTransactionRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository,
                                BalanceTransactionRepositoryInterface $balanceTransactionRepository,
                                BetRepositoryInterface $betRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->balanceTransactionRepository = $balanceTransactionRepository;
        $this->betRepository = $betRepository;
    }

    public function createNewBet(NewBetRequest $request)
    {
        $stakeAmount = cleanInput($request->get('stake_amount'));
        $playerId = cleanInput($request->get('player_id'));
        $selections = $request->get('selections');
        $playerPostData = $this->extractPlayerDataFromRequest($request->all());

        //Start DB transaction
        DB::beginTransaction();

        //Create player if not exists
        $player = $this->playerRepository->firstOrCreate($playerPostData,'id',$playerId);

        //Calculate win amount
        $amount = $this->calculateWinAmount($stakeAmount, $selections);

        //Validate win amount
        if($amount > MAX_WIN_AMOUNT){
            $this->response = $this->generateError(ERROR_CODE_MAX_WIN_AMOUNT_EXCEEDED,ERROR_MSG_MAX_WIN_AMOUNT_EXCEEDED);

            //Rollback the DB changes
            DB::rollBack();
        }else{
            //Calculate player balance amount
            $balance = $player->balance - $stakeAmount;

            if($balance < 0){
                $this->response = $this->generateError(ERROR_CODE_INSUFFICIENT_BALANCE,ERROR_MSG_INSUFFICIENT_BALANCE);

                //Rollback the DB changes
                DB::rollBack();
            }else{

                //Create balance transaction
                $this->balanceTransactionRepository->create([
                    'player_id'=>$player->id,
                    'amount'=>$amount,
                    'amount_before'=>$amount
                ]);

                //Create bet
                $bet = $this->betRepository->create(['stake_amount'=>$stakeAmount]);
                $betSelectionCreateArray = $this->getBetSelectionSaveDataArray($selections);

                //Insert selections for created bet
                $bet->betSelections()->createMany($betSelectionCreateArray);

                //Update player balance amount
                $this->playerRepository->update(['balance'=>$balance],$player->id);

                //Commit the db changes
                DB::commit();
            }
        }


        return $this->apiResponse($this->response,$this->apiResponseCode);
    }

    private function extractPlayerDataFromRequest(array $postData)
    {
        return  [
            'id'=>$postData['player_id'],
            'balance'=>PLAYER_DEFAULT_BALANCE_AMOUNT
        ];
    }

    private function calculateWinAmount(float $stakeAmount,array $selections)
    {
        $winAmount = $stakeAmount;
        if(is_array($selections)){
            foreach ($selections as $selection){
                $winAmount =   $selection['odds'] * $winAmount;
            }
        }
        return $winAmount;
    }

    private function getBetSelectionSaveDataArray(array $selections)
    {
        $betSelections = [];
        if(is_array($selections)){
            foreach ($selections as $selection){
                array_push($betSelections,[
                    'selection_id'=>$selection['id'],
                    'odds'=>$selection['odds']
                ]);
            }
        }
        return $betSelections;
    }
}
