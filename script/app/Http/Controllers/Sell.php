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
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Redis;


class Sell extends Controller
{
    const NEW_ITEMS_CHANNEL = 'items.to.sale';

    public function __construct()
    {
        parent::__construct();
        $this->redis = Redis::connection();
    }

    public function __destruct()
    {
        $this->redis->disconnect();
    }


    public function newItems()
    {
        $config = Config::find(1);
        $jsonItems = $this->redis->lrange(self::NEW_ITEMS_CHANNEL, 0, -1);
        foreach ($jsonItems as $jsonItem) {
            $items = json_decode($jsonItem, true);
            foreach ($items as $item) {
                $item['quality'] = 0;
                if ($item['quality']) $item['quality'] = $item['quality'];
                $ts = Items::where('market_name', 'LIKE', '%' . $item['name'] . '%')->get();
                $i = 0;
                foreach ($ts as $key => $tt) {

                    $gg[$i] = Items::find($ts[$i]['id']);
                    $gg[$i]->counts += 1;
                    $gg[$i]->save();
                    if ($gg[$i]->counts >= $config->countitems)
                        $i++;
                }
                Inventory::create($item);

            }
            $this->redis->lrem(self::NEW_ITEMS_CHANNEL, 1, $jsonItem);
        }
        return response()->json(['success' => true]);
    }

    public function listbuy()
    {


        $config = Config::find(1);
        $item = Items::orderby('id', 'desc')->orderBy('case_id', 'desc')->where('counts', '<', $config->countitems)->where('status', 1)->get();
        $i = 0;

        foreach ($item as $key => $it) {

            if (Redis::get('item' . $item[$i]['id']) != 0 and strlen(Redis::get('item' . $item[$i]['id'])) > 5 and Redis::get('item' . $item[$i]['id']) < Carbon::now()->subHours(1)->getTimestamp()) {
                Redis::del('item' . $item[$i]['id']);
            }
            if ((Redis::get('item' . $item[$i]['id']) != 0 and $item[$i]['counts'] < $config->countitems and Redis::get('item' . $item[$i]['id']) < $config->countitems and strlen(Redis::get('item' . $item[$i]['id'])) < 3) || (!Redis::get('item' . $item[$i]['id']))) {

              return $this->check_price($it);
            }

            $i++;
        }

    }

    public function check_price($item)
    {

        $config = Config::find(1);
        $cn = 0;
        //Покупаем оружие
        $myCurl2 = curl_init();
        curl_setopt_array($myCurl2, array(
            CURLOPT_URL => "https://market.csgo.com/itemdb/current_730.json",
            CURLOPT_RETURNTRANSFER => true
        ));
        $bd = curl_exec($myCurl2);
        curl_close($myCurl2);

        $bd2 = json_decode($bd);


        // $handle = fopen("https://market.csgo.com/itemdb/" . $bd2->db, "r");
        $csv = file_get_contents("https://market.csgo.com/itemdb/" . $bd2->db, "r");
        $csv = explode("\n", trim($csv));
        $i = 0;
        $name = $item["market_name"];
        $name = str_replace(' (После полевых испытаний)', '', $name);
        $name = str_replace('(После полевых испытан', '', $name);
        $name = str_replace(' (Прямо с завода)', '', $name);
        $name = str_replace(' (Закаленное в боях)', '', $name);
        $name = str_replace(' (Немного поношенное)', '', $name);
        $name = str_replace(' (Поношенное)', '', $name);
        $shmot = [];
        foreach ($csv as $line) {

            $array2[$i] = explode(';', $line);
            $array2[$i][9] = str_replace(' (После полевых испытаний)', '', $array2[$i][9]);
            $array2[$i][9] = str_replace('(После полевых испытан', '', $array2[$i][9]);
            $array2[$i][9] = str_replace(' (Прямо с завода)', '', $array2[$i][9]);
            $array2[$i][9] = str_replace(' (Закаленное в боях)', '', $array2[$i][9]);
            $array2[$i][9] = str_replace(' (Немного поношенное)', '', $array2[$i][9]);
            $array2[$i][9] = str_replace(' (Поношенное)', '', $array2[$i][9]);
//
            $test[$i] = $array2[$i][9];
            $pos = mb_strpos($array2[$i][9], $name);
            if ($pos === false) {

            } elseif ($array2[$i][2] / 100 < $item['price'] + 20) {

                $shmot = $array2[$i];
            }
            $i++;
        }


        if ($shmot == []) {
            $this->redis->set('item' . $item['id'], Carbon::now()->getTimestamp());
            return ['status' => false];
        }


        // Цена и хеш
        $myCurl = curl_init();
        curl_setopt_array($myCurl, array(
            CURLOPT_URL => 'https://market.csgo.com/api/ItemInfo/' . $shmot[0] . '_' . $shmot[1] . '/ru/?key=' . $config->keycsgotm,
            CURLOPT_RETURNTRANSFER => true
        ));
        $response = curl_exec($myCurl);
        curl_close($myCurl);
        $datas = json_decode($response, TRUE);

        if (isset($datas['error'])) {

        } else {

            $myCurl2 = curl_init();
            curl_setopt_array($myCurl2, array(
                CURLOPT_URL => "https://market.csgo.com/api/Buy/" . $shmot[0] . '_' . $shmot[1] . "/" . $shmot[2] . "/" . $datas['hash'] . "/?key=" . $config->keycsgotm,
                CURLOPT_RETURNTRANSFER => true
            ));
            $buy = curl_exec($myCurl2);
            curl_close($myCurl2);

            $buy2 = json_decode($buy, TRUE);


            $result = $buy2['result'];
            if ($buy2['result'] == 'ok') {
                $result = 'Купили предмет';

                $count = $this->redis->get('item' . $item['id']);
                if (!$count) {
                    $this->redis->set('item' . $item['id'], 0);
                }
                $this->redis->set('item' . $item['id'], $count + 1);
            }

            AutoBuy::create(
                ['log' => str_replace('"', '', $result), 'name' => $shmot[9], 'ids' =>  $shmot[0] . '_' . $shmot[1], 'price' => $shmot[2]]
            );


        }


    }


    public function listupdate()
    {
        $item = Items::orderby('price', 'asc')->get();

        $i = 0;
        foreach ($item as $key => $it) {
            if ($it->updated_at->getTimestamp() < Carbon::now()->subHours(5)->getTimestamp() || $it->price == 0) {
                $price = round($this->update_price($it->market_hash_name) * 77);
                Items::where('market_hash_name', $it->market_hash_name)->update(['price' => $price, 'updated_at' => Carbon::now()]);
            }
            $i++;
        }
        return ['status' => false, 'count' => count($item)];
    }

    public function update_price($name)
    {
        $url = 'https://api.csgofast.com/price/all';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $auth = curl_exec($curl);
        if ($auth) {
            $json = json_decode($auth, true);
            foreach ($json as $names => $item) {

                if ($names == $name) {
                    return $item;
                    break;
                }
            }
        } else {


            $google2fa = new Google2FA();
            $url = 'http://bitskins.com/api/v1/get_item_price/?api_key=eae13dc6-a7e4-4120-86a3-f7ff441a35b4&code=' . $google2fa->getCurrentOtp('MWNIZY4BYUS2V2MH') . '&names=' . urlencode($name);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $auth = curl_exec($curl);


            if ($auth) {
                $json = json_decode($auth, true);
                return $json['data']['prices'][0]['price'];
                //  return  Items::where('market_hash_name', $name)->update( [ 'price' =>$json['data']['prices'][0]['price']]);
            }
        }
    }

}