<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use App\Models\OpenMeteoWeather;


class TgBotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            [
                'status' => 'success',
                'active' => true          
            ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $textMessage = Arr::get($input, 'message.text');
        $chatId = Arr::get($input, 'message.chat.id');
        $this->writeLogFile(json_encode($input, JSON_PRETTY_PRINT));
        $openMeteoWeather = new OpenMeteoWeather();
        /* return response()->json(
            [
                'status' => 'success',
                'data' => $openMeteoWeather->getCurrentValue('time', true),
                'txt' => $openMeteoWeather->description()       
            ], 200);*/
            //return $openMeteoWeather->description();
        if(true) {
            $arrayQuery = [
                'chat_id'       => $chatId,
                'text'          => $openMeteoWeather->description(),
                'parse_mode'    => "html",
            ];
            $this->sendTgMessage($arrayQuery);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Writes TG messages into log-file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function writeLogFile(string $string, bool $clear = false)
    {
        $now = date("Y-m-d H:i:s");
        if(!$clear) {
            Storage::disk('local')->append('tg-bot/messages.log', 
                $now." ".$string."\r\n"
            );
        } else {
            $a = Storage::disk('local')->put('tg-bot/messages.log', 
                $now." ".print_r($string, true)."\r\n"
            );
        }
    }

    private function sendTgMessage(array $getQuery)
    {
        $tgToken = env('TG_TOKEN');
        $res = Http::get("https://api.telegram.org/bot". $tgToken ."/sendMessage", $getQuery);
/*        $ch = curl_init("https://api.telegram.org/bot". $tgToken ."/sendMessage?" . http_build_query($getQuery));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);*/

        $this->writeLogFile('ok' => Arr::get($res, 'ok'), true);
    }
}
