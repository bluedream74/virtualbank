<?php

namespace App\Models;

use DB;

class Merchant extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'merchant';
    public $primaryKey = 'id';
    protected $fillable = ['user_id, name', 'u_name', 'u_name_fu', 'u_address', 'u_email', 'u_tel', 'u_url', 'u_banktype', 'u_bankcode', 'u_branch', 'u_branchcode', 'u_holdernumber', 'u_holdertype', 'u_holdername_sei', 'u_holdername_mei', 'u_holdername_fu_sei', 'u_holdername_fu_mei', 'u_status', 'u_visa_fee', 'u_master_fee', 'u_jcb_fee', 'u_amex_fee', 'qrcode'];

    public static function getAll()
    {
        $list = self::all()->sortByDesc('created_at');
        foreach($list as $merchant)
            $merchant->shops = Shop::where('member_id', $merchant->name)->count();
        return $list;
    }

    public static function getDetail($merchant_id)
    {
        $merchant = self::findById($merchant_id);
        $user = User::findById($merchant->user_id);
        $merchant->password1 = $user->password1;
        $merchant->shops = Shop::where('member_id', $merchant->name)->get();
        $merchant->payment_url = url('/') . '/payment/s=merchant&p=' . $merchant->name . '&m=1';
        return $merchant;
    }

    public static function getUserByName($name)
    {
        $merchant = self::where('name', '=', $name)->first();
        return ($merchant != null) ? self::getDetail($merchant->id): null;
    }

    public static function getUserInfoByName($name)
    {
        $merchant = self::where('name', '=', $name)->first();
        return ($merchant != null) ? $merchant: null;
    }

    public static function getSearch($data)
    {
        // where
        $arrWhere = array();
        if(isset($data['name']) && ($data['name'] != ''))
            array_push($arrWhere, ['merchant.name', '=', $data['name']]);
        if(isset($data['u_name']) && ($data['u_name'] != ''))
            array_push($arrWhere, ['merchant.u_name', '=', $data['u_name']]);
        if(isset($data['u_tel']) && ($data['u_tel'] != ''))
            array_push($arrWhere, ['merchant.u_tel', '=', $data['u_tel']]);
        if(isset($data['u_email']) && ($data['u_email'] != ''))
            array_push($arrWhere, ['merchant.u_email', '=', $data['u_email']]);
        if(isset($data['u_holdername_fu']) && ($data['u_holdername_fu'] != ''))
            array_push($arrWhere, ['merchant.u_holdername_fu_sei', '=', $data['u_holdername_fu']]);
        if(isset($data['u_status']) && ($data['u_status'] != ''))
            array_push($arrWhere, ['merchant.u_status', '=', $data['u_status']]);

        $start_date = '1900-01-01';
        $end_date = '9999-01-01';
        if(isset($data['start_date']) && ($data['start_date'] != ''))
            $start_date = $data['start_date'];
        if(isset($data['end_date']) && ($data['end_date'] != ''))
            $end_date = $data['end_date'];

        $start_date .= ' 00:00';
        $end_date .= ' 23:59';

        // search
        $list = Merchant::select('merchant.*')
                    ->where('merchant.created_at', '>=', $start_date)
                    ->where('merchant.created_at', '<=', $end_date)
                    ->where($arrWhere)
                    ->orderBy('merchant.created_at', 'DESC')
                    ->get();

        foreach($list as $merchant)
            $merchant->shops = Shop::where('member_id', $merchant->name)->count();
        return $list;
    }
}
