<?php

namespace App\Models;

class PaymentMethod extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'payment_method';
    public $primaryKey = 'id';
    protected $fillable = ['name'];
}
