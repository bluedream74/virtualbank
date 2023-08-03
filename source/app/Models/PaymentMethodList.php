<?php

namespace App\Models;

class PaymentMethodList extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'payment_method_list';
    public $primaryKey = 'id';
    protected $fillable = ['payment_id', 'user_id'];

    public static function add($data, $user_id)
    {
        self::where('user_id', $user_id)->delete();

        foreach($data as $item){
            $type = new PaymentMethodList();
            $type->payment_id = $item;
            $type->user_id = $user_id;
            $type->save();
        }
    }

    public static function getPaymentList($user_id)
    {
        $arr_list = array();

        $list = self::where('user_id', $user_id)->get();
        foreach($list as $item){
            $type = PaymentMethod::findById($item->payment_id);
            $item->payment_name = $type->name;
            array_push($arr_list, $item);
        }

        return $arr_list;
    }
}
