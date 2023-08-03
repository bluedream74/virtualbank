<?php

namespace App\Models;

class CardType extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'card_type';
    public $primaryKey = 'id';
    protected $fillable = ['name'];
}
