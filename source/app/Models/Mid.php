<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 2018.09.29
 * Time: PM 11:02
 */

namespace App\Models;

//require_once __DIR__.'/Twilio/autoload.php';
//use Twilio\Rest\Client;

class Mid extends BaseModel{

    protected $table = 'mid';
    public $primaryKey = 'id';
    protected $fillable = ['mid'];

}