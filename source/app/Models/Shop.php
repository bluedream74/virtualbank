<?php

namespace App\Models;

class Shop extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'shop';
    public $primaryKey = 'id';
    protected $fillable = ['user_id', 'member_id', 'name', 's_name', 's_name_fu', 's_address', 's_tel', 's_url', 's_email', 's_group_name', 's_visa_fee', 's_master_fee', 's_jcb_fee', 's_amex_fee', 's_transaction_fee', 's_cancel_fee', 's_charge_fee', 's_enter_fee', 's_paycycle_id', 's_agency_name', 's_agency_fee', 's_status', 's_memo', 'qrcode', 's_manager_name', 's_manager_tel', 's_manager_email', 'mid'];


    public static function getAllByUser($merchant_id)
    {
        // merchant
        $merchant = Merchant::findById($merchant_id);

        // get array
        $arr_shop = array();
        $list = self::all()->sortByDesc('created_at');
        foreach($list as $shop){
            if($shop->member_id == $merchant->name)
                array_push($arr_shop, self::getDetail($shop->id));
        }

        return $arr_shop;
    }

    public static function getAll()
    {
        $arr_shop = array();
        $list = self::all()->sortByDesc('created_at');
        foreach($list as $shop)
            array_push($arr_shop, self::getDetail($shop->id));
        return $arr_shop;
    }

    public static function getDetail($id)
    {
        $shop = self::findById($id);
        $user = User::findById($shop->user_id);
        $shop->password1 = $user->password1;

        $payCycle = PayCycle::findById($shop->s_paycycle_id);
        $shop->s_paycycle_name = $payCycle->name;
        $shop->service_types = ServiceTypeList::getServiceList($id);
        $shop->card_types = CardTypeList::getCardList($id);

        $shop->payment_url = url('/') . '/payment/s=shop&p=' . $shop->name . '&m=1';;
        return $shop;
    }

    public static function getAllNamesByUser($merchant_id)
    {
        $list = self::where('member_id', $merchant_id)->get();
        $arr_names = array();
        foreach($list as $shop)
            array_push($arr_names, $shop->name);

        return $arr_names;
    }

    public static function getShopByName($name)
    {
        $shop = self::where('name', '=', $name)->first();
        return ($shop != null) ? self::getDetail($shop->id) : null;
    }


    public static function getShopInfoByName($name)
    {
        $shop = self::where('name', '=', $name)->first();
        return ($shop != null) ? $shop : null;
    }

    public static function getSearch($data)
    {
        // where
        $arrWhere = array();
        if(isset($data['name']) && ($data['name'] != ''))
            array_push($arrWhere, ['shop.name', '=', $data['name']]);
        if(isset($data['s_name']) && ($data['s_name'] != ''))
            array_push($arrWhere, ['shop.s_name', '=', $data['s_name']]);
        if(isset($data['s_tel']) && ($data['s_tel'] != ''))
            array_push($arrWhere, ['shop.s_tel', '=', $data['s_tel']]);
        if(isset($data['member_id']) && ($data['member_id'] != ''))
            array_push($arrWhere, ['shop.member_id', '=', $data['member_id']]);
        if(isset($data['s_paycycle']) && ($data['s_paycycle'] != ''))
            array_push($arrWhere, ['shop.s_paycycle_id', '=', $data['s_paycycle']]);
        if(isset($data['s_status']) && ($data['s_status'] != ''))
            array_push($arrWhere, ['shop.s_status', '=', $data['s_status']]);
        if(isset($data['mid']) && ($data['mid'] != ''))
            array_push($arrWhere, ['shop.mid', '=', $data['mid']]);

        $start_date = '1900-01-01';
        $end_date = '9999-01-01';
        if(isset($data['start_date']) && ($data['start_date'] != ''))
            $start_date = $data['start_date'];
        if(isset($data['end_date']) && ($data['end_date'] != ''))
            $end_date = $data['end_date'];

        $start_date .= ' 00:00';
        $end_date .= ' 23:59';

        // search
        $list = self::select('shop.*')
                    ->where('shop.created_at', '>=', $start_date)
                    ->where('shop.created_at', '<=', $end_date)
                    ->where($arrWhere)
                    ->orderBy('shop.created_at', 'DESC')
                    ->get();

        $arr_list = array();
        
        $service_name = '';
        if(isset($data['s_service']) && ($data['s_service'] != '')) {
            $service = ServiceType::findById($data['s_service']);
            $service_name = $service->name;
        }

        // filter by s_service
        foreach($list as $item) {
            
            $payCycle = PayCycle::findById($item->s_paycycle_id);
            $item->s_paycycle_name = $payCycle->name;
            $item->service_types = ServiceTypeList::getServiceList($item->id);
            
            if($service_name != '') {
                foreach($item->service_types as $service) {
                    if($service->service_name == $service_name) {
                        array_push($arr_list, $item);  
                        break;
                    }
                }                    
            }
            else {
                array_push($arr_list, $item);
            }
        }

        return $arr_list;
    }
}
