<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model{

    protected $table = 'inventory';

    protected $fillable = ['classid', 'name', 'status','inventoryId','steam_price','buyer_id','market_hash_name','type','quality','rarity'];

    public $timestamps = false;

}