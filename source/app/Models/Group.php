<?php

namespace App\Models;

use Auth;

class Group extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'group';
    public $primaryKey = 'id';

    public static function getAll()
    {
        $arr_group = array();

        $list = self::all()->sortByDesc('created_at');
        foreach($list as $group)
            array_push($arr_group, self::getDetail($group->id));
        return $arr_group;
    }

    public static function getDetail($id)
    {
        $group = self::findById($id);
        $user = User::findById($group->user_id);
        $group->password1 = $user->password1;
        return $group;
    }

    public static function getGroupByName($group_name)
    {
        return self::where('name', $group_name)->first();
    }

    public static function getAllMerchantByGroup($id)
    {
        $arr_merchants = array();

        $group = self::findById($id);
        if($group->g_merchantcount > 0) {
            $arr_merchant_ids = explode(PHP_EOL, $group->g_merchantlist);
            foreach($arr_merchant_ids as $merchant_id)
                array_push($arr_merchants, Merchant::getUserByName($merchant_id));
        }

        return $arr_merchants;
    }

    public static function getAllShopByGroup($id)
    {
        $arr_shops = array();

        $group = self::findById($id);
        if($group->g_shopcount > 0) {
            $arr_shop_ids = explode(PHP_EOL, $group->g_shoplist);
            foreach($arr_shop_ids as $shop_id) {
                array_push($arr_shops, Shop::getShopByName($shop_id));
            }                
        }

        return $arr_shops;
    }

    public static function getGorupEmailsByShopName($shop_id)
    {
        $arr_address = array();

        $list = self::where('g_shoplist', 'like', '%' . $shop_id . '%')->get();
        foreach($list as $group) {
            if($group->g_thanks_email1)
                array_push($arr_address, $group->g_thanks_email1);
            if($group->g_thanks_email2)
                array_push($arr_address, $group->g_thanks_email2);
            if($group->g_thanks_email3)
                array_push($arr_address, $group->g_thanks_email3);
        }

        return $arr_address;
    }

    public static function getSearch($data)
    {
        // where
        $arrWhere = array();
        if(isset($data['name']) && ($data['name'] != ''))
            array_push($arrWhere, ['name', 'like', '%' . $data['name'] . '%']);
        if(isset($data['g_name']) && ($data['g_name'] != ''))
            array_push($arrWhere, ['g_name', 'like', '%' . $data['g_name'] . '%']);
        if(isset($data['shop_id']) && ($data['shop_id'] != ''))
            array_push($arrWhere, ['g_shoplist', 'like', '%' . $data['shop_id'] . '%']);
        if(isset($data['merchant_id']) && ($data['merchant_id'] != ''))
            array_push($arrWhere, ['g_merchantlist', 'like', '%' . $data['merchant_id'] . '%']);
        if(isset($data['shop_name']) && ($data['shop_name'] != '')) 
            array_push($arrWhere, ['g_shopnamelist', 'like', '%' . $data['shop_name'] . '%']);

        if(isset($data['g_status']) && ($data['g_status'] != ''))
            array_push($arrWhere, ['g_status', '=', $data['g_status']]);
        if(isset($data['g_kind']) && ($data['g_kind'] != ''))
            array_push($arrWhere, ['g_kind', '=', $data['g_kind']]);

        // date
        $start_date = '1900-01-01';
        $end_date = '9999-01-01';
        if(isset($data['start_date']) && ($data['start_date'] != ''))
            $start_date = $data['start_date'];
        if(isset($data['end_date']) && ($data['end_date'] != ''))
            $end_date = $data['end_date'];

        $start_date .= ' 00:00';
        $end_date .= ' 23:59';

        // search
        $list = self::where('created_at', '>=', $start_date)
                    ->where('created_at', '<=', $end_date)
                    ->where($arrWhere)
                    ->orderBy('created_at', 'DESC')
                    ->get();
            
        return $list;
    }

    // get summary from year, month
    public static function getShopSummary($data, $user)
    {
        if($user->type == 3) {
            $group = self::getGroupByName($user->name);
            $arr_shop = explode(PHP_EOL, $group->g_shoplist);
        }
        else {
            $arr_shop = [$user->name];
        }

        $list = Transaction::getGroupShopSummary($data, $arr_shop, $user->type); 
        return $list;
    }
}
