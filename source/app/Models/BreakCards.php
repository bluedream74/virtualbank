<?php

namespace App\Models;

class BreakCards extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'break_cards';
    public $primaryKey = 'id';
    protected $fillable = ['card_number', 'username'];

    public static function checkBreakCard($card_number, $username)
    {
        $result_failure_time = intval(Setting::getValueByName('result_failure_time'));
        $result_failure_count = intval(Setting::getValueByName('result_failure_count'));

        // get break_card information with username, card_number
        $card = self::where('card_number', $card_number)->where('username', $username)->first();
        if($card) {
            if($card->status == 1) {

                // check if result_failure_time is over
                $delta = time() - strtotime($card->updated_at);
                if($delta > $result_failure_time * 60) {
                    $card = self::findById($card->id);
                    $card->status = 0;
                    $card->updated_at = date('Y-m-d H:i:s');
                    $card->save();
                    return false;
                }

                return true;
            }
            else {
                $transactions = Transaction::getTransactionByInfo($card_number, $username, $result_failure_count, $card->updated_at);
            }
        }
        else {
            $transactions = Transaction::getTransactionByInfo($card_number, $username, $result_failure_count);
        }

        // check if breaking are {{ $result_failure_count }} times
        if(sizeof($transactions) < $result_failure_count)
            return false;
        
        foreach($transactions as $transaction) {
            if($transaction->status != '失敗') {
                return false;
            }
        }

        // if failure, create break_card
        if($card) {
            $card->status = 1;
            $card->save();
        }
        else {
            $breakcard = new BreakCards();
            $breakcard->card_number = $card_number;
            $breakcard->username = $username;
            $breakcard->status = 1;
            $breakcard->save();
        }           

        return true;
    }
}
