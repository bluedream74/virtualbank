<?php

namespace App\Models;

class Setting extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'setting';
    public $primaryKey = 'id';
    protected $fillable = ['field', 'value'];

    public static function setPageLen($page_len)
    {
        $setting = self::where('field', 'page_len')->first();
        $setting->value = $page_len;
        $setting->save();
    }

    public static function getPageLen()
    {
        $setting = self::where('field', 'page_len')->first();
        return $setting->value;
    }

    public static function getStartDate()
    {
        $setting = self::where('field', 'start_date')->first();
        return $setting->value;
    }

    public static function getEndDate()
    {
        $setting = self::where('field', 'end_date')->first();
        return $setting->value;
    }

    public static function setDates($start, $end)
    {
        $setting = self::where('field', 'start_date')->first();
        $setting->value = $start;
        $setting->save();

        $setting = self::where('field', 'end_date')->first();
        $setting->value = $end;
        $setting->save();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function setToday($db_date, $enable)
    {
        $setting = self::where('field', 'enable_db_date')->first();
        $setting->value = $enable;
        $setting->save();

        $setting = self::where('field', 'db_date')->first();
        $setting->value = $db_date;
        $setting->save();
    }

    public static function getToday()
    {
        $setting = self::where('field', 'enable_db_date')->first();
        if($setting->value != 0){
            $setting = self::where('field', 'db_date')->first();
            return $setting->value;
        }

        return date('Y-m-d');
    }

    public static function enableDBDate()
    {
        $setting = self::where('field', 'enable_db_date')->first();
        return $setting->value;
    }

    public static function sendPaymentToken()
    {
        $setting = self::where('field', 'send_payment_token')->first();
        if ($setting != null){
            return $setting->value;
        }
        else {
            return '0';
        }
    }

    public static function getSessionTimeLimit()
    {
        $setting = self::where('field', 'session_time_limit')->first();
        if($setting == null)
            return 5;
        return (int)$setting->value;
    }

    public static function getMid()
    {
        $setting = self::where('field', 'mid')->first();
        if($setting == null)
            return 1;
        return (int)$setting->value;
    }

    public static function setMid($mid)
    {
        $setting = self::where('field', 'mid')->first();
        $setting->value = $mid;
        $setting->save();
    }
}
