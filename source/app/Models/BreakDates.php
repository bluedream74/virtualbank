<?php

namespace App\Models;

class BreakDates extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'break_dates';
    public $primaryKey = 'id';
    protected $fillable = ['date'];
}
