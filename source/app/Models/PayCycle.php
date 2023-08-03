<?php

namespace App\Models;

class PayCycle extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'paycycle_type';
    public $primaryKey = 'id';
    protected $fillable = ['name'];
}
