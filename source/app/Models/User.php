<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'username', 'type', 'password1', 'remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public static function findById($id, $field = null)
    {
        $user = self::where('id', '=', $id)->first();
        if (!$user) {
            return null;
        }
        if (!$field) {
            return $user;
        }
        return @$user->{$field};

    }

    public static function getAll()
    {
        $arr_user = array();

        $list = self::all()->sortByDesc('created_at');
        foreach($list as $user)
            array_push($arr_user, self::getDetail($user->id));

        return $arr_user;
    }

    public static function getDetail($user_id)
    {
        $user = self::findById($user_id);
        if($user->type == '1'){
            $user->data = Merchant::getUserByName($user->name);
        }else {
            $user->data = Shop::getShopByName($user->name);
        }

        return $user;
    }

    public static function getUserByName($name)
    {
        $user = User::where('name', '=', $name)->first();
        return self::getDetail($user->id);
    }

    public static function getUserStatus($name)
    {
        $user = User::where('name', '=', $name)->first();
        $info = self::getDetail($user->id);
        if($user->type == 1)
            return $info->data->u_status;
        return $info->data->s_status;
    }

    public static function getUserInfoByName($name)
    {
        $user = User::where('name', '=', $name)->first();
        return ($user != null) ? $user : null;
    }
}
