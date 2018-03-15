<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AutoBuy extends Model{

    protected $table = 'log_autobot';

    protected $fillable = ['name', 'ids', 'price','log'];

    public $timestamps = true;

}