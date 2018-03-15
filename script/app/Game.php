<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Game extends Model{

	protected $table = 'game';

	protected $fillable = ['winner', 'case', 'price','ticket','userid','one','weapon','theree','two','five','seven','six','four','nine','eight','status','item_id'];

	public $timestamps = true;

}