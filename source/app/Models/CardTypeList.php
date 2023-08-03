<?php

namespace App\Models;

class CardTypeList extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'card_type_list';
    public $primaryKey = 'id';
    protected $fillable = ['card_id', 'user_id'];

    public static function add($data, $user_id)
    {
        self::where('user_id', $user_id)->delete();

        foreach($data as $item){
            $type = new CardTypeList();
            $type->card_id = $item;
            $type->user_id = $user_id;
            $type->save();
        }
    }

    public static function removeAll($user_id)
    {
        self::where('user_id', $user_id)->delete();
    }

    public static function getCardList($user_id)
    {
        $arr_list = array();

        $list = self::where('user_id', $user_id)->get();
        foreach($list as $item){
            $type = CardType::findById($item->card_id);
            $item->card_name = $type->name;
            array_push($arr_list, $item);
        }

        return $arr_list;
    }
}
