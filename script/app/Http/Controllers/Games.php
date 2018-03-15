<?php namespace App\Http\Controllers;

use App\Cases;
use App\Config;
use App\Game;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Inventory;
use App\Items;
use App\User;
use Carbon\Carbon;
use Redis;
use Illuminate\Http\Request;

class Games extends Controller
{


    const SENDITEMS_CHANNEL = 'send.items';
    const NEW_WINNER = 'new.winner';

    public function __construct()
    {
        parent::__construct();
        $this->redis = Redis::connection();
    }

    public function __destruct()
    {
        $this->redis->disconnect();
    }

    public function aj_sell_or_wait(Request $request)
    {
        $game = Game::where('id', \Crypt::decrypt($request->get('bsh')))->where('status', 1)->where('buy', 0)->where('send', 0)->first();
        $game->buy = 1;
        $game->save();
		$user = User::find($game->userid);
        $user->money += $game->price;
        $user->save();
		 $item = Items::find($game->item_id);
        $item->market_name = str_replace(' (После полевых испытаний)', '', $item->market_name);
        $item->market_name = str_replace('(После полевых испытан', '', $item->market_name);
        $item->market_name = str_replace(' (Прямо с завода)', '', $item->market_name);
        $item->market_name = str_replace(' (Закаленное в боях)', '', $item->market_name);
        $item->market_name = str_replace(' (Немного поношенное)', '', $item->market_name);
        $item->market_name = str_replace(' (Поношенное)', '', $item->market_name);
		 Items::where('market_name', 'LIKE', '%' .$item->market_name . '%')->update(['counts' => 'counts'+1]);
        return response()->json(["status" => "success" , "balance" => $user->money ]);

    }

    public function aj_sell_transfer(Request $request)
    {
        //   return response()->json(["status" => "success"]);
        $game = Game::where('id', \Crypt::decrypt($request->get('bsh')))->where('status', 1)->where('buy', 0)->where('send', 0)->first();
        if (is_null($game)) response()->json(["status" => "error"]);
        $item = Items::find($game->item_id);
        $item->market_name = str_replace(' (После полевых испытаний)', '', $item->market_name);
        $item->market_name = str_replace('(После полевых испытан', '', $item->market_name);
        $item->market_name = str_replace(' (Прямо с завода)', '', $item->market_name);
        $item->market_name = str_replace(' (Закаленное в боях)', '', $item->market_name);
        $item->market_name = str_replace(' (Немного поношенное)', '', $item->market_name);
        $item->market_name = str_replace(' (Поношенное)', '', $item->market_name);
        $kek = Inventory::where('name', $item->market_name)->where('status', 0)->first();
        if (is_null($kek)) response()->json(["status" => "error"]);
        $user = User::find($game->userid);
        $game->send = 1;
        $game->save();
        $kek->buyer_id = $user->id;
        $kek->status = 1;
        $kek->save();

      
    
        $this->sendItem($kek, $user);
        return response()->json(["status" => "success"]);

    }

    public function sendItem($item, $user)
    {


        $value = [
            'id' => $item->id,
            'itemId' => $item->inventoryId,
            'partnerSteamId' => $user->steamid64,
            'accessToken' => $user->accessToken
        ];

        $this->redis->rpush(self::SENDITEMS_CHANNEL, json_encode($value));

    }

    public function randomitem(Request $request)
    {
        $caseinfo = Cases::Where('name', $request->get('case'))->first();

        $games = Game::orderBy('id', 'desc')->where('case', $caseinfo->id)->where('status', 1)->first();

        $weapon = json_decode($games->weapon);
        $item = Items::where('classid', $weapon->classid)->first();

        $this->redis->publish(self::NEW_WINNER, json_encode(["status" => "success",
                "id" => $games->id,
                "user_id" => $this->user->id, "userName" => $this->user->username,
                "firstName" => $weapon->fullname . " | " . $weapon->spacename, "type" => $weapon->type, "classid" => $weapon->classid,
                "caseimage" => $caseinfo->images]
        ));


        return ["status" => "success", "bsh" => \Crypt::encrypt($games->id), "weapon" => ["fullname" => $weapon->fullname . ' | ' . $weapon->spacename
            , "firstName" => $weapon->fullname . ' | ' . $weapon->spacename
            , "secondName" => $weapon->fullname . ' | ' . $weapon->spacename,
            "type" => $weapon->type,
            "classid" => $weapon->classid,
            "price" => $games->price, "id" => $item->id]
            , "balance" => $this->user->money];

    }

    public function setItemStatus(Request $request)
    {
        $item = Inventory::find($request->get('id'));
        if (!is_null($item)) {
            $item->status = $request->get('status');
            $item->save();
            return $item;
        }
        return response()->json(['success' => false]);
    }


    public function newgame(Request $request)
    {
        if ($request->get('action') == 'openCase') {
            if (\Cache::has('openCase.user.' . $this->user->id)) return response()->json(['status' => 'error_bot', 'msg' => 'Вы слишком часто жмёте кнопку!']);
            \Cache::put('openCase.user.' . $this->user->id, '', 0.05);
			
            $caseinfo = Cases::Where('name', $request->get('case'))->first();

            //->orderByRaw("RAND()");

            $config = COnfig::find(1);
            $i = 0;
            $prices = 50;
            if (Game::where('status', 1)->where('case', '>', 0)->orderBy('id', 'desc')->count() > 5) {
                $prices = [];
                foreach (Game::where('status', 1)->where('case', '>', 0)->orderBy('id', 'desc')->take(5)->get() as $money) {
                    $prices[$i] = $money->price;
                    $i++;
                }

                $prices = array_sum($prices);
            }


            if ($prices < 50) {
                $items = Items::where('case_id', $caseinfo->id)->where('price', '<', 100)->having('counts', '>',0)->orderBy('price', 'desc')->orderByRaw("RAND()")->first();
            } else {
                $items = Items::where('case_id', $caseinfo->id)->orderByRaw("RAND()")->having('counts', '>',0)->first();
            }
			//вот так )
if($this->user->youtuber)  $items = Items::where('case_id', $caseinfo->id)->orderByRaw("RAND()")->where('price','>',500)->having('counts', '>',0)->first();
            if (empty($this->user->trade_link)) return ["status" => "error_steam", "msg" => "Укажите ссылку на обмен!"];
            if ($this->user->money < $caseinfo->price) return ["status" => "error_game", "msg" => "Пополните баланс ! "];
            if (is_null($items) || Items::where('case_id', $caseinfo->id)->where('counts', '!=', 0)->count() < 1 || $caseinfo->status == 0 || $caseinfo->status == 2) return ["status" => "error_bot", "msg" => "Оружия расхватали быстрей чем пирожки, подождите пока мы зальём новую партию оружия."];


            $items->market_name = str_replace(' (После полевых испытаний)', '', $items->market_name);
            $items->market_name = str_replace('(После полевых испытан', '', $items->market_name);
            $items->market_name = str_replace(' (Прямо с завода)', '', $items->market_name);
            $items->market_name = str_replace(' (Закаленное в боях)', '', $items->market_name);
            $items->market_name = str_replace(' (Немного поношенное)', '', $items->market_name);
            $items->market_name = str_replace(' (Поношенное)', '', $items->market_name);
            $name = explode('|', $items->market_name);
            $items->fullname = $name[0];
            $items->spacename = $name[1];
            $returnValue = ['fullname' => $items->fullname, 'spacename' => $items->spacename,
                'type' => $items->type, 'classid' => $items->classid, 'item_id' => $items->item_id, 'price' => $items->price];

            Game::create(['userid' => $this->user->id, 'status' => 1, 'case' => $caseinfo->id,
                'weapon' => json_encode($returnValue),
                'item_id' => $items->id, 'price' => $items->price
            ]);
            $this->user->money -= $caseinfo->price;
            $this->user->save();

Items::where('market_name', 'LIKE', '%' .$items->market_name . '%')->update(['counts' => 'counts'-1]);
            return response()->json(['status' => 'success', "currentCase" => $caseinfo->name, 'balance' => $this->user->money, 'weapon' => $returnValue]);


        }


    }


}
