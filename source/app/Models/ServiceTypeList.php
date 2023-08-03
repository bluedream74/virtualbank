<?php

namespace App\Models;

class ServiceTypeList extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'service_type_list';
    public $primaryKey = 'id';
    protected $fillable = ['service_id', 'user_id'];

    public static function add($data, $user_id)
    {
        self::where('user_id', $user_id)->delete();

        foreach($data as $item){
            $type = new ServiceTypeList();
            $type->service_id = $item;
            $type->user_id = $user_id;
            $type->save();
        }
    }

    public static function removeAll($user_id)
    {
        self::where('user_id', $user_id)->delete();
    }

    public static function getServiceList($user_id)
    {
        $arr_list = array();

        $list = self::where('user_id', $user_id)->get();
        foreach($list as $item){
            $type = ServiceType::findById($item->service_id);
            $item->service_name = $type->name;
            array_push($arr_list, $item);
        }

        return $arr_list;
    }
}
