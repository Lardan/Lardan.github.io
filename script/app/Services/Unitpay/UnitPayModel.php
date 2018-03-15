<?php namespace App\Services\Unitpay;

use DB;
use App\User;

class UnitPayModel
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

    function getPaymentByUnitpayId($gdonateId)
    {
        return DB::table('gdonate_payments')->where('gdonateId',$gdonateId)->first();
    }

    function confirmPaymentByUnitpayId($gdonateId)
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