<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Items extends Model{
	
	 protected $table = 'items';
	
	 protected $fillable = ['case_id', 'type', 'status','spacename','fullname','image', 'price','market_hash_name'];

    public $timestamps = true;

}