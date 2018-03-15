<?php namespace App\Http\Controllers;

use App\AutoBuy;
use App\Cases;
use App\Config;
use App\Game;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Inventory;
use App\Items;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Admin extends Controller
{


    public function game(Request $request)
    {
        $game = Game::where('status', '!=', 1)->where('case', '!=', 0)->where('userid', $this->user->id)->first();
        return view('admin.game', compact('game'));
    }

    public function givemoney($id, Request $request)
    {
        $user = User::find($id);
        if ($request->get('money')) {
            $user->money += $request->get('money');
            $user->save();
            \DB::table('logmoney')->insertGetId(['userid' => $id, 'money' => $request->get('money'), 'comment' => $request->get('comment'), 'admin' => $this->user->id, 'date' => Carbon::now()]);
            return redirect('/admin/users');
        }
        return view('admin.users.givemoney', compact('user'));
    }

    public function lastmoney($id)
    {
        $users = \DB::table('logmoney')->orderby('id', 'desc')->where('userid', $id)->paginate(20);
        return view('admin.users.lastmoney', compact('users'));
    }

    public function userid($id)
    {
        $user = User::find($id);
        return view('admin.users.user', compact('user'));
    }

    public function userdit(Request $request)
    {
        $user = User::find($request->get('id'));
        $user->money = $request->get('money');
        $user->trade_link = $request->get('trade_link');
        $user->banchat = $request->get('banchat');
        $user->username = $request->get('username');
        $user->save();
        return redirect('/admin/users');

    }

    public function statscase(Request $request)
    {

        $case = Cases::join('game', 'case.id', '=', 'game.case')->join('items', 'case.id', '=', 'items.case_id')->select('case.id as caseid','case.price as caseprice','case.name', \DB::raw('count(items.id) as counts'), \DB::raw('SUM(case.price) as monys'), \DB::raw('count(game.id) as counter'), \DB::raw('SUM(case.price) as top_value'))->groupBy('case.id')->get();
        if ($request->get('day') == 'today') {
            $case = Cases::join('game', function($join)
            {
                $join->on( 'case.id', '=', 'game.case')->
                   where('game.created_at', '>=', Carbon::today());
            })->join('items', 'case.id', '=', 'items.case_id')->select('case.id as caseid','case.price as caseprice','case.name', \DB::raw('count(items.id) as counts'), \DB::raw('SUM(case.price) as monys'), \DB::raw('count(game.id) as counter'), \DB::raw('SUM(case.price) as top_value'))->groupBy('case.id')->get();
        }
        if ($request->get('day') == 'vchera') {
            $case = Cases::join('game', function($join)
            {
                $join->on( 'case.id', '=', 'game.case')-> where('game.created_at', '<=', Carbon::now()->subDays(1));
            })->join('items', 'case.id', '=', 'items.case_id')->select('case.id as caseid','case.price as caseprice','case.name', \DB::raw('count(items.id) as counts'), \DB::raw('SUM(case.price) as monys'), \DB::raw('count(game.id) as counter'), \DB::raw('SUM(case.price) as top_value'))->groupBy('case.id')->get();
        }
        if ($request->get('day') == 'nedela') {
            $case = Cases::join('game', function($join)
            {
                $join->on( 'case.id', '=', 'game.case')-> where('game.created_at', '>=', Carbon::now()->subWeeks(1));
            })->join('items', 'case.id', '=', 'items.case_id')->select('case.id as caseid','case.price as caseprice','case.name', \DB::raw('count(items.id) as counts'), \DB::raw('SUM(case.price) as monys'), \DB::raw('count(game.id) as counter'), \DB::raw('SUM(case.price) as top_value'))->groupBy('case.id')->get();
        }
        if ($request->get('day') == 'moonth') {
            $case = Cases::join('game', function($join)
            {
                $join->on( 'case.id', '=', 'game.case')-> where('game.created_at', '>=', Carbon::now()->subMonth(1));
            })->join('items', 'case.id', '=', 'items.case_id')->select('case.id as caseid','case.price as caseprice','case.name', \DB::raw('count(items.id) as counts'), \DB::raw('SUM(case.price) as monys'), \DB::raw('count(game.id) as counter'), \DB::raw('SUM(case.price) as top_value'))->groupBy('case.id')->get();
        }
        return view('admin.stats.case', compact('case'));
    }


    public function lastcase($id)
    {

        $user = Game::orderby('id', 'desc')->where('userid', $id)
            ->join('users', 'game.userid', '=', 'users.id')->join('case', 'game.case', '=', 'case.id')->select('game.*', 'case.name as casename','case.price as caseprice')->get();
        return view('admin.stats.lastcase', compact('user'));
    }

    public function statsusers()
    {
        $user = User::get();
        return view('admin.stats.user', compact('user'));
    }


    public function stats()
    {

        $moneysite = Game::join('case', 'game.case', '=', 'case.id')
            ->select(\DB::raw('SUM(game.price) as top_value2'), \DB::raw('SUM(case.price) as top_value'))->first();
        $items = Game::where('send', 1)->count();
        $case = Game::count();
        $casetoday = Game::where('created_at', '>=', Carbon::today())->count();
        $users = User::count();
        $userstoday = User::where('created_at', '>=', Carbon::today())->count();
        $moneystats = \DB::table('log_pay')->orderby('id', 'desc')->get();
        return view('admin.stats.index', compact('moneysite', 'items', 'case', 'casetoday', 'users', 'userstoday', 'moneystats'));
    }

    public function users()
    {

        $users = User::orderby('id', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function items(Request $request)
    {

        $items = Items::orderby('id', 'desc')->orderBy('case_id', 'desc')->join('case', 'items.case_id', '=', 'case.id')->select('items.*', 'case.name as case_name')->paginate(20);
        if ($request->get('sort')) {
            $items = Items::orderby('price', 'desc')->orderBy('case_id', 'desc')->join('case', 'items.case_id', '=', 'case.id')->select('items.*', 'case.name as case_name')->paginate(20);

        }
        return view('admin.items.index', compact('items'));
    }


    public function itemsban(Request $request)
    {

        $items = Items::orderby('id', 'desc')->orderBy('case_id', 'desc')->join('case', 'items.case_id', '=', 'case.id')->select('items.*', 'case.name as case_name')->paginate(20);
        return view('admin.items.itemsban', compact('items'));
    }


    public function search(Request $request)
    {

        $items = Items::orderby('id', 'desc')->where('market_name', 'LIKE', '%' . $request->get('name') . '%')->join('case', 'items.case_id', '=', 'case.id')->select('items.*', 'case.name as case_name')->paginate(20);
        return view('admin.items.index', compact('items'));

    }

    public function search2(Request $request)
    {

        $users = User::select('users.id',
            'users.username', 'users.trade_link',
            'users.avatar', 'users.money',
            'users.steamid64', \DB::raw('COUNT(game.id) as games_played'))->join('game', 'game.userid', '=', 'users.id')->where('username', 'LIKE', '%' . $request->get('name') . '%')->orderby('id', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));

    }

    public function itemscat(Request $request, $id)
    {

        $items = Items::orderby('id', 'desc')->where('case_id', $id)->join('case', 'items.case_id', '=', 'case.id')->select('items.*', 'case.name as case_name')->paginate(20);
        return view('admin.items.index', compact('items'));
    }


    public function itemsedits($id, Request $request)
    {
        $items = Items::find($id);
        $items->status = $request->get('status');
        $items->save();
    }

    public function itemsedit(Request $request)
    {
        $items = Items::find($request->get('id'));
        if (is_null($items)) $items = new Items;

        if (is_null($items->market_hash_name) || $items->market_hash_name == '' || is_null($items->market_name) || $items->market_name == '') {

            $homepage = file_get_contents('http://api.steampowered.com/ISteamEconomy/GetAssetClassInfo/v0001?key=D7EF769135FBEA69DBB99A48883B87A7&format=json&language=ru&appid=730&class_count=2&classid0=0&classid1=' . $request->get('classid') . '');
            $json = json_decode($homepage, true);
            $json['result'][$request->get('classid')]['type'] = str_replace(' StatTrak™', '', $json['result'][$request->get('classid')]['type']);
            $json['result'][$request->get('classid')]['type'] = str_replace(' ★,', '', $json['result'][$request->get('classid')]['type']);
            $type = explode(', ', $json['result'][$request->get('classid')]['type']);

            $items->type = $this->getClassRarity($type[1]);
            $items->classid = $request->get('classid');
            $items->market_hash_name = $json['result'][$request->get('classid')]['market_hash_name'];
            $items->market_name = $json['result'][$request->get('classid')]['market_name'];
            $items->case_id = $request->get('case_id');
        } else {
            $items->classid = $request->get('classid');
            $items->type = $request->get('type');
            $items->price = $request->get('price');
            $items->case_id = $request->get('case_id');
            $items->market_name = $request->get('market_name');
            $items->status = $request->get('status');
        }
        $items->save();
        return redirect('/admin/items');
    }

    public static function getClassRarity($type)
    {
        switch ($type) {
            case 'Армейское качество':
                return 'milspec';
                break;
            case 'Запрещенное':
                return 'restricted';
                break;
            case 'Засекреченное':
                return 'classified';
                break;
            case 'Тайное':
                return 'covert';
                break;
            case 'Ширпотреб':
                return 'common';
                break;
            case 'Промышленное качество':
                return 'common';
                break;
        }
    }

    public function itemsnew()
    {
        $case = Cases::get();
        return view('admin.items.itemsnew', compact('case'));
    }

    public function config(Request $request)
    {
        $config = Config::find(1);
        if ($request->get('maxprice')) $config->maxprice = $request->get('maxprice');
        if ($request->get('keycsgotm')) $config->keycsgotm = $request->get('keycsgotm');
        if ($request->get('countitems')) $config->countitems = $request->get('countitems');

        $config->save();
        return view('admin.config', compact('config'));
    }


    public function autobuy()
    {
        $log = AutoBuy::orderby('id', 'desc')->paginate(20);
        return view('admin.log', compact('log'));
    }


    public function itemsid($id, Request $request)
    {
        if ($request->get('status')) {
            Items::find($id)->delete();
            return redirect('/admin/items');
        }
        $items = Items::find($id);
        $case = Cases::get();
        return view('admin.items.items', compact('items', 'case'));
    }

    public function cases()
    {
        $cases = Cases::orderBy('id', 'desc')->get();

        return view('admin.cases.index', compact('cases'));
    }

    public function casesid($id, Request $request)
    {
        if ($request->get('status')) {
            Cases::find($id)->delete();
            return redirect('/admin/case');
        }
        $cases = Cases::find($id);
        return view('admin.cases.cases', compact('cases'));
    }

    public function casesnew()
    {

        return view('admin.cases.casesnew');
    }

    public function casesedit(Request $request)
    {
        $pages = Cases::find($request->get('id'));
        if (is_null($pages)) $pages = new Cases;
        $pages->name = $request->get('name');
        $pages->price = $request->get('price');
        $pages->status = $request->get('status');
        $pages->images = $request->get('images');
        $pages->nomer = $request->get('nomer');
        $pages->save();
        return redirect('/admin/case');
    }

    public function index()
    {
        $game = \DB::table('game')->where('case', '>', 0)->where('userid', '!=', 209)->whereNotBetween('userid', [99, 199])->whereNotBetween('userid', [419, 618])->
        where('game.status', '!=', 0)->orderby('id', 'desc')->join('users', 'game.userid', '=', 'users.id')->join('case', 'game.case', '=', 'case.id')->select('game.*', 'case.name as case_name', 'users.username as winner_username', 'users.steamid64 as winner_steamid64', 'users.avatar as winner_avatar')->take(20)->get();
        return view('admin.index', compact('game'));
    }


}