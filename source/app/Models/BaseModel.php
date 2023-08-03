<?php
/**
 * Created by kbin.
 * Date: 8/30/2018
 * Time: 10:11 AM
 */

namespace App\Models;

use App\Models\QueryFilters\QueryFilter;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * |---------------------------------------------------------------------
     * |
     * | @description flag delete;
     * | DELFLAG_TRUE => is_deleted;
     * | DELFLAG_FALSE => is_active;
     * |---------------------------------------------------------------------
     */

    const STATUS_ENABLE = 'E';
    const STATUS_DISABLE = 'D';


    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    /**************************************************
     *   Name: findById()
     *   Function: get record by primary key
     *   Parameter:
     *
     *   Return: array
     *   Created by @kbin 2018/08/30
     *************************************************/
    public static function findById($id, $field = null)
    {
        $item = self::where('id', '=', $id)->first();
        if (!$item) {
            return null;
        }
        if (!$field) {
            return $item;
        }
        return @$item->{$field};

    }
}