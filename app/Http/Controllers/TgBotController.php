<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use App\Models\EcowittWeather;


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
        $text = __('Incorrect command');
        $textMessage = Arr::get($input, 'message.text');
        $chatId = Arr::get($input, 'message.chat.id');
        $this->writeLogFile(json_encode($input, JSON_PRETTY_PRINT));
        if ($textMessage === "/current") {
            $weather = new EcowittWeather();
            $text = $weather->description();
        }
        
        if(!!$chatId) {
            $arrayQuery = [
                'chat_id'       => $chatId,
                'text'          => $text,
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
        $tgApiUrl = config('custom.telegram.token');
        $tgToken = config('custom.telegram.api_url');
        $this->writeLogFile(json_encode([
            1 => $tgToken, 2 => $tgApiUrl
        ], JSON_PRETTY_PRINT));
        $res = Http::get($tgApiUrl . $tgToken ."/sendMessage", $getQuery);
        //$this->writeLogFile($res, true);
    }
}
