<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class PermsController extends Controller
{
    public function index()
    {
        if (!$res = Cache::get('get_perms_status')) {
            $res = Cache::rememberForever('get_perms_status', function () {
                $headers = [
                    'Authorization' => 'Bearer ' . env('TOKEN_API_ENTREPRISE'),
                    'Accept'        => 'application/json',
                ];

                $version = 'v2';

                // siren bourbon digital : 839070596 for testing

                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $client->request('GET', '/' . $version . '/privileges', [
                        'headers' => $headers,
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
