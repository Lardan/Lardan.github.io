<?php namespace App\Services\GDonate;

use DB;
use App\User;

class GDonateModel
{

    static function getInstance()
    {
        return new self();
    }


    function createPayment($gdonateId, $account, $sum, $itemsCount)
    {
		
		 return DB::table('gdonate_payments')->insert([
            'gdonateId' => $gdonateId,
            'account' => $account,
            'sum' => $sum,
            'itemsCount' => $itemsCount,
            'dateCreate' => time(),
            'status' => 0,
        ]);
		

    }

    function getPaymentByGDonateId($gdonateId)
    {
		
		return DB::table('gdonate_payments')->where('gdonateId',$gdonateId)->first();

    }

    function confirmPaymentByGDonateId($gdonateId)
    {
       return DB::table('gdonate_payments')->where('gdonateId',$gdonateId)->update([
            'status' => 1,
            'dateComplete' => time(),
        ]);
    }
    
    function getAccountByName($account)
    {
        return User::find($account);
    }
    
    function donateForAccount($account, $count)
    {
         $user = User::find($account);
        $user->money = $user->money + $count;
        $user->save();
    }
}