<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model{
	
	 protected $table = 'case';
	
	 protected $fillable = ['name', 'images', 'price'];

    public $timestamps = false;

}