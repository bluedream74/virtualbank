<?php

namespace App\Models;

class ServiceType extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'service_type';
    public $primaryKey = 'id';
    protected $fillable = ['name'];
}
