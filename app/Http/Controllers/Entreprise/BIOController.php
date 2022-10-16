<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class BIOController extends Controller
{
    public function index($siret)
    {
        if (!$res = Cache::get("{$siret}.get_bio")) {
            $res = Cache::rememberForever("{$siret}.get_bio", function () use ($siret) {
                $headers = [
                    'Authorization' => 'Bearer ' . env('TOKEN_API_ENTREPRISE'),
                    'Accept'        => 'application/json',
                ];

                $version = 'v2';

                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $client->request('GET', '/' . $version . '/certificats_agence_bio/' . $siret, [
                        'headers' => $headers,

                        'json' => [
                            'context'   => '81449011600013',
                            'recipient' => '53464391100017',
                            'object'    => 'Testing Purpose',
                        ],

                    ]);
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return json_encode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }
}
