<?php

/**
 * Created by PhpStorm.
 * User: kbin
 * Date: 8/20/2018
 * Time: 11:48 AM
 */
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Customer\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App;
use App\Models\Merchant;
use App\Models\Shop;
use App\Models\User;

class FeeController extends CustomerController
{
    protected $platform = 'customer';

    public function index()
    {
        Session::put('menu', 'home');

        // low fee
        $this->view_datas['s_visa_fee'] = $this->getLowFee(Auth::user()->name, 1);
        $this->view_datas['s_master_fee'] = $this->getLowFee(Auth::user()->name, 2);
        $this->view_datas['s_jcb_fee'] = $this->getLowFee(Auth::user()->name, 3);
        $this->view_datas['s_amex_fee'] = $this->getLowFee(Auth::user()->name, 4);

        // merchant fee
        $this->view_datas['visa_fee'] = $this->getMerchantFee(Auth::user()->name, 1);
        $this->view_datas['master_fee'] = $this->getMerchantFee(Auth::user()->name, 2);
        $this->view_datas['jcb_fee'] = $this->getMerchantFee(Auth::user()->name, 3);
        $this->view_datas['amex_fee'] = $this->getMerchantFee(Auth::user()->name, 4);

        return view("{$this->platform}.fee.index",  ['datas' => $this->view_datas]);
    }

    public function showEdit(Request $request)
    {
        $this->view_datas['visa_fee'] = $this->getMerchantFee(Auth::user()->name, 1);
        $this->view_datas['master_fee'] = $this->getMerchantFee(Auth::user()->name, 2);
        $this->view_datas['jcb_fee'] = $this->getMerchantFee(Auth::user()->name, 3);
        $this->view_datas['amex_fee'] = $this->getMerchantFee(Auth::user()->name, 4);

        return view("{$this->platform}.fee.edit",  ['datas' => $this->view_datas]);
    }

    public function postEdit(Request $request)
    {
        $params = $request->all();

        if (Auth::user()->type == '1'){
            $merchant = Merchant::getUserByName(Auth::user()->name);

            $new_merchant = Merchant::findById($merchant->id);
            $new_merchant->u_visa_fee = $params['visa_fee'];
            $new_merchant->u_master_fee = $params['master_fee'];
            $new_merchant->u_jcb_fee = $params['jcb_fee'];
            $new_merchant->u_amex_fee = $params['amex_fee'];
            $new_merchant->save();

        }else {
            $shop = Shop::getShopByName(Auth::user()->name);

            $new_shop = Shop::findById($shop->id);
            $new_shop->sm_visa_fee = $params['visa_fee'];
            $new_shop->sm_master_fee = $params['master_fee'];
            $new_shop->sm_jcb_fee = $params['jcb_fee'];
            $new_shop->sm_amex_fee = $params['amex_fee'];
            $new_shop->save();
        }


        return redirect('/fee-setting')->with('status', 'updated');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Get Card Fee from Merchant or Shop
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getMerchantFee($username, $card_type)
    {
        $user = User::getUserByName($username);
        if($user->type == '1'){
            $merchant = Merchant::getUserByName($username);
            switch($card_type){
                case 1:
                    return floatval($merchant->u_visa_fee);

                case 2:
                    return floatval($merchant->u_master_fee);

                case 3:
                    return floatval($merchant->u_jcb_fee);

                case 4:
                    return floatval($merchant->u_amex_fee);
            }
        }

        // shop
        $shop = Shop::getShopByName($username);
        switch($card_type){
            case 1:
                return floatval($shop->sm_visa_fee);

            case 2:
                return floatval($shop->sm_master_fee);

            case 3:
                return floatval($shop->sm_jcb_fee);

            case 4:
                return floatval($shop->sm_amex_fee);
        }
    }

    public function getLowFee($username, $card_type)
    {
        $user = User::getUserByName($username);
        if($user->type == '1'){

            $merchant = Merchant::getUserByName($username);
            switch($card_type){
                case 1:
                    return floatval($merchant->u_visa_fee_low);

                case 2:
                    return floatval($merchant->u_master_fee_low);

                case 3:
                    return floatval($merchant->u_jcb_fee_low);

                case 4:
                    return floatval($merchant->u_amex_fee_low);
            }
        }
        else {

            $shop = Shop::getShopByName($username);
            switch($card_type){
                case 1:
                    return floatval($shop->s_visa_fee);

                case 2:
                    return floatval($shop->s_master_fee);

                case 3:
                    return floatval($shop->s_jcb_fee);

                case 4:
                    return floatval($shop->s_amex_fee);
            }
        }
    }
}