<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

    public function __construct()
    {
        // MIDDLE PARA ÁREA AUTENTICADA
        $this->middleware('auth')->except(['feed', 'weather']);
    }

    // ÁREA DA HOME
    public function index()
    {
        return view('home');
    }

    // API PREVISÃO DO TEMPO OPEN WEATHER
    public function weather()
    {
        // RECUPERA OS DADOS DA API
        $response = Http::get('api.openweathermap.org/data/2.5/weather?id=3448433&appid=9e17a0c01916abbbf7729fa2b702f3b4');

        // GRAVA A RESPONSTA NA VARIÁVEL
        $data = $response->json();

        // CONVERTE DE KELVINS PARA CELCIUS
        $temp = $data['main']['temp'] -273.15;

        // RETORNA A RESPOSTA EM JSON
        return response()->json(number_format($temp, '0'));
    }

    // FEED DE NOTÍCIAS G1
    public function feed()
    {
        // CAPTURA OS DADOS DO RSS FEED (G1)
        $response = Http::get('http://g1.globo.com/dynamo/economia/rss2.xml');

        // CONVERTE A RESPOSTA PARA JSON
        $xmlResponse = simplexml_load_string($response->body());

        // CONVERTE DE JSON PARA ARRAY
        $responseArray = json_decode(json_encode($xmlResponse), true);

        // RETORNA A RESPOSTA EM JSON DOS ITENS DA FEED
        return response()->json($responseArray['channel']['item']);
    }
}
