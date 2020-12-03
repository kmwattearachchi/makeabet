<?php


namespace App\Modules\Bet\Http\Requests;

use App\Rules\MaxDecimalPointsValidation;
use App\Rules\ValidJsonStructure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class NewBetRequest  extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'player_id' => ['bail','required','integer','min:1'],
            'stake_amount' => ['bail','required','numeric','min:'.MINIMUM_STAKE_AMOUNT,'max:'.MAXIMUM_STAKE_AMOUNT,new MaxDecimalPointsValidation(STAKE_AMOUNT_MAX_DECIMAL_POINTS)],
            'selections' => ['bail','required','array','min:'.MINIMUM_SELECTIONS,'max:'.MAXIMUM_SELECTIONS],
            'selections.*.id'=>['bail','required','integer','min:1','distinct'],
            'selections.*.odds'=>['bail','required','numeric','min:'.MINIMUM_ODD_INTERVAL,'max:'.MAXIMUM_ODD_INTERVAL, new MaxDecimalPointsValidation(ODD_INTERVAL_MAX_DECIMAL_POINTS)]
        ];
    }

    public function messages()
    {
        return [
            'player_id.required'=>'Player id is required.',
            'stake_amount.required'=>'Stake amount is required.',
            'stake_amount.min'=>'Minimum stake amount is '.MINIMUM_STAKE_AMOUNT,
            'stake_amount.max'=>'Maximum stake amount is '.MAXIMUM_STAKE_AMOUNT,
            'selections.required'=>'Minimum number of selections is '.MINIMUM_SELECTIONS,
            'selections.min'=>'Minimum number of selections is '.MINIMUM_SELECTIONS,
            'selections.max'=>'Maximum number of selections is '.MAXIMUM_SELECTIONS,
            'selections.*.odds.min'=>'Minimum odds are '.MINIMUM_ODD_INTERVAL,
            'selections.*.odds.max'=>'Maximum odds are '.MAXIMUM_ODD_INTERVAL,

            'selections.*.id.distinct'=>'Duplicate selection found'
        ];
    }

}
/*
{
    "id": 1,
            "odds": "1000"
        },
{
    "id": 1,
            "odds": "1000"
        }*/
