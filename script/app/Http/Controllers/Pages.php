<?php namespace App\Http\Controllers;

use App\Cases;
use App\Config;
use App\Game;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Items;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Request;

class Pages extends Controller
{

    public static function winners()
    {
        return Game::orderby('id', 'desc')->where('status', 1)->where('case', '>', 0)->join('users', 'game.userid', '=', 'users.id')->select('game.*', 'users.username as winner_username', 'users.steamid64 as winner_steamid64', 'users.avatar as winner_avatar')->take(8)->get();

    }

    public function caseinfo()
    {
        $case = Cases::where('id', '!=', 0)->where('status', 1)->get();
        $i = 0;
        foreach ($case as $cs) {
            $cs->counstitem = Items::where('case_id', $cs->id)->where('counts', '>', 0)->count();
            $info[$i] = $cs;
            $i++;
        }
        return $info;
    }

    public function stats()
    {

        return ['maxcovert' => Game::where('case', '>', 0)->join('items', function ($join) {
            $join->on('game.item_id', '=', 'items.id')
                ->where('type', 'LIKE', '%covert%');
        })->count(), 'maxuser' => User::count(), 'maxknife' => Game::where('case', '>', 0)->join('items', function ($join) {
            $join->on('game.item_id', '=', 'items.id')->where('market_name', 'LIKE', '%★%');
        })->count(), 'maxgame' => Game::where('case', '>', 0)->count()];
    }


    public function index()
    {

        if ((Request::get('reg') || Request::get('REG')) and Auth::Guest()) {
            \Cookie::queue(\Cookie::make('ref', str_replace("reg", "", Request::get('reg')), 60));
        } elseif ((Request::get('reg') || Request::get('REG')) and Auth::user()->partner == 0 and Auth::user()->id != str_replace("reg", "", Request::get('reg'))) {
            \Cookie::queue(\Cookie::make('ref', str_replace("reg", "", Request::get('reg')), 60));

        }

        $case = Cases::where('status', '!=', 0)->orderBy('nomer', 'desc')->get();
        $free = 0;
        if (!Auth::guest() and Game::where('userid', '=', $this->user->id)->where('case', '=', 0)->first()) $free = 1;
        return view('pages.index', compact('case', 'free'));
    }

    public function reviews()
    {
        return view('pages.reviews');
    }

    public function top()
    {

        $best24 = Game::orderby('price','desc')->join('users', 'game.userid', '=', 'users.id')
            ->select('game.*', 'users.username as winner_username', 'users.id as winner_id', 'users.avatar as winner_avatar')
            ->limit(4)
            ->get();


        $users = User::select('users.id',
            'users.username',
            'users.avatar',
            'users.steamid64',
            'game.case as case',
            \DB::raw('SUM(game.price) as top_value'),
            \DB::raw('SUM(case.price) as moneys'),
            \DB::raw('COUNT(game.id) as games_played')
        )
            ->join('game', function ($join) {
                $join->on('game.userid', '=', 'users.id')
                    ->where('game.status', '=', 1)->where('case', '>', 0);
            })->join('case', 'case.id', '=', 'game.case')
            ->groupBy('users.id')
            ->orderBy('top_value', 'desc')
            ->limit(20)
            ->get();

        $place = 1;
        $i = 0;

        foreach ($users as $u) {
            $users[$i]->win_rate = round($users[$i]->wins_count / $users[$i]->games_played, 3) * 100;
            $users[$i]->place = $i;
            $i++;
        }
        return view('pages.top', compact('users', 'place','best24'));
    }

    public function faq()
    {
        if (Request::ajax()) {

            return view('pages.faq');
        }

        return view('pages.faq');
    }

    public function partner()
    {
        if (Auth::user()) {
            $partnermoney = User::where('partner', $this->user->id)->join('payment', function ($join) {
                $join->on('users.id', '=', 'payment.user_id')
                    ->where('payment.status', '=', 1);
            })->sum('balance');

            $user = User::where('partner', $this->user->id)->get();
            $i = 0;

            foreach ($user as $key => $it) {
                $money[$i] = $it->money;
                $i++;
            }


            if (!isset($money)) {
                $money = 0;
            } else {
                $money = count($money);
                if ($money < 5000) $money = 5;
                if ($money > 5000) $money = 10;
                if ($money > 10000) $money = 15;
            }

        }
        return view('pages.partner', compact('money', 'partnermoney'));
    }

    public function lastwinner()
    {

        return \DB::table('game')->orderby('id', 'desc')->where('status', '=', 1)->where('case', '>', 0)->join('users', 'game.userid', '=', 'users.id')->select('game.*', 'users.username as winner_username', 'users.steamid64 as winner_steamid64', 'users.avatar as winner_avatar')->get();
    }


    public function cases($id)
    {
        if (isset($id) && Cases::where('id', $id)->count()) {

            $case = Cases::find($id);
            return view('pages.case', compact('case'));
        }
        return redirect()->route('index');
    }

    public function profile($id)
    {
        if (isset($id) && User::where('id', $id)->count()) {
            if (Auth::user()) {
                $partnermoney = User::where('partner', $this->user->id)->join('payment', function ($join) {
                    $join->on('users.id', '=', 'payment.user_id')
                        ->where('payment.status', '=', 1);
                })->sum('balance');

                $user = User::where('partner', $this->user->id)->get();
                $i = 0;

                foreach ($user as $key => $it) {
                    $money[$i] = $it->money;
                    $i++;
                }


                if (!isset($money)) {
                    $money = 0;
                } else {
                    $money = count($money);
                    if ($money < 5000) $money = 5;
                    if ($money > 5000) $money = 10;
                    if ($money > 10000) $money = 15;
                }

            }
            $user = User::find($id);
            $item = Game::where('userid', $user->id)->orderby('id', 'desc')->where('case', '>', 0)->where('status', 1)->paginate(5);
            return view('pages.profile', compact('user', 'item', 'money', 'partnermoney'));
        }
        return redirect()->route('index');
    }

    public function pload($id)
    {
        if (isset($id) && User::where('id', $id)->count()) {
            $item = Game::where('userid', $id)->orderby('id', 'desc')->where('case', '>', 0)->where('status', 1)->get();
            $i = 0;
            foreach ($item as $it) {
                if ($i >= Request::get('num1')) {
                    $weapon[$i] = json_decode($it->weapon);
                }
                $i++;
            }
            return json_encode($weapon);

        }
        return redirect()->route('index');
    }


    public function postLang($lang)
    {
        if (in_array($lang, $this->languages)) {
            \Session::set('lang', $lang);
            if (!Auth::guest()) {
                User::where('id', $this->user->id)->update(['language' => $lang]);
            }
        }
        return redirect()->route('index');
    }


    public function pay()
    {
        //H5TDU1Lbi4qxXQjU6D9S
        //yA3qM9xH3y6U5BPMeykP
        $config = Config::find(1);
        $sum = Request::get('num');
        $mrh_login = "caseupone";
        $mrh_pass1 = "LPb4i3RC7JI68JiwNtma";
        $inv_id = mt_rand();
        if ($sum != 0) {
            DB::table('payment')->insertGetId(['uid' => $inv_id, 'user_id' => $this->user->id,
                'balance' => $sum]);

        }
		return \Redirect::to('https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=' . $mrh_login . '&OutSum=' . $sum . '&InvId=' . $inv_id . '&Desc=Пополнение баланса на CaseUp.One&SignatureValue=' . md5($mrh_login . ":" . $sum . ":" . $inv_id . ":" . $mrh_pass1));
		
    //    header('Location: https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=' . $mrh_login . '&OutSum=' . $sum . '&InvId=' . $inv_id . '&Desc=Пополнение баланса на CaseUp.One&SignatureValue=' . md5($mrh_login . ":" . $sum . ":" . $inv_id . ":" . $mrh_pass1));


        // header('Location: https://www.nextpay.ru/buy/index.php?command=show_product_form_ext&product_id=7497&customer='.$this->user->id.'&ext_order_cost=' . $sum . '');
        //https://www.nextpay.ru/buy/index.php?command=show_product_form_ext&product_id=7497&customer=1&ext_order_cost=50
    }


    public function getResult()
    {
        $out_sum = Request::get('OutSum');
        $inv_id = Request::get('InvId');
        $user = DB::table('payment')->select('user_id')->where('uid', '=', $inv_id)->first();
        $checksum = Request::get('SignatureValue');
        $password2 = 'GxrLxX8bDEc2C624SsKJ';

        if (strtolower($checksum) == strtolower(md5($out_sum . ":" . $inv_id . ":" . $password2))) {
            if (DB::table('payment')->where('uid', '=', $inv_id) && DB::table('payment')->where('balance', '=', $out_sum)) {

                $payment = DB::table('payment')->where('uid', '=', $inv_id)->first();

                if ($payment->status == 0) {
                    DB::table('payment')->where('uid', '=', $inv_id)->update([
                        'status' => 1
                    ]);
                    $money = count($out_sum);
                    if ($money < 5000) $money = 5;
                    if ($money > 5000) $money = 10;
                    if ($money > 10000) $money = 15;
                    $addBalanceToUser = User::find($user->user_id);
                    $addBalanceToUser->money += $out_sum;
                    $addBalanceToUser->save();
                    if (!is_null($addBalanceToUser->partner)) {
                        $addBalanceTopartner = User::find($addBalanceToUser->partner);
                        $addBalanceTopartner->money += $out_sum / 100 * $money;
                        $addBalanceTopartner->save();
                    }
                    return response()->json(['status' => 'success']);
                }


            }
        }
        return response()->json(['status' => 'error']);
    }


    public function validnextpay()
    {
        return 'ok';
    }


}
