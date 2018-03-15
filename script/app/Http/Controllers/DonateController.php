<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\GDonate\GDonate;
use App\Services\GDonate\GDonateEvent;
use App\Services\Unitpay\UnitPay;
use App\Services\Unitpay\UnitPayEvent;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\User;
class DonateController extends Controller
{

    public function Digseller(Request $request)
    {

        $uniqode = $request->get('uniquecode');
////////////////////////////////////////////////////////////////////////////
        if (isset($uniqode)) { // Если код передается скрипту с именем xcode

            if (strlen($uniqode) == 16) { // Код на digiseller равен 16 символам
                $id_seller = 593422;

                $pass_DS = "ES555Dim";
                $user = $request->get('badboy');
                $code = $uniqode; // Вводим переменную с кодом


                $sign = md5($id_seller . ":" . $code . ":" . $pass_DS); // Тут заполняем в соответствии с своими данными
                $xml = '<?xml version="1.0" encoding="windows-1251"?>
<digiseller.request>
<id_seller>' . $id_seller . '</id_seller>
<unique_code>' . $code . '</unique_code>
<sign>' . $sign . '</sign>
</digiseller.request>';

                $answer = $this->_GetAnswer("http://shop.digiseller.ru/xml/check_unique_code.asp", $xml);

                $xmlres = simplexml_load_string($answer);


                $xmlres = $this->object2array($xmlres); // переводим XML в массив


                if ($xmlres['retdesc'] == "не найден unique_code (код ошибки 1)") { // проверяем, есть ли вообще такой код
                    return "Код не найден";
                } else {
                    $amount = $xmlres['amount']; // получаем сумму
                    $inv = $xmlres['inv'];

                    $query = DB::table('log_pay')->where('inv', $inv)->first();

                    if (!$query) {
                        DB::table('log_pay')->insertGetId(['inv' => $inv, 'amount' => $amount, 'data' => Carbon::now()->getTimestamp(), 'user' => $user, 'uniq' => $uniqode, 'created_at' => Carbon::now()
                        ]);


                        $money = 0;

                        if (count($amount) < 5000) $money = 5;
                        if (count($amount)  > 5000) $money = 10;
                        if (count($amount)  > 10000) $money = 15;

                        $addBalanceToUser = User::find($user);
                        $addBalanceToUser->money += $amount;
                        $addBalanceToUser->save();
                        if ($addBalanceToUser->partner > 0) {
                            $addBalanceTopartner = User::find($addBalanceToUser->partner);
                            $addBalanceTopartner->money += $amount / 100 * $money;
                            $addBalanceTopartner->save();
                        }



                        return redirect()->route('index');

                    } else {
                        return redirect()->route('index');
                    }

                }
            } else {
                return redirect()->route('index');
            }
        } else {

            return response()->json(['status' => 'error']);
        }
    }

    public function _GetAnswer($address, $xml)
    {
        $ch = curl_init($address);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $result = curl_exec($ch);
        return $result;
    }

    public function object2array($object)
    {
        return @json_decode(@json_encode($object), 1);
    }

    public function GDonateDonate(Request $request)
    {
        $payment = new GDonate(
            new GDonateEvent(),
            $request
        );
        return $payment->getResult();
    }


    public function unitpayDonate(Request $request)
    {
        $payment = new UnitPay(
            new UnitPayEvent(),
            $request
        );
        return $payment->getResult();
    }
}
