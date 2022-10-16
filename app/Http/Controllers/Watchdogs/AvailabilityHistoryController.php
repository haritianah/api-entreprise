<?php

namespace App\Http\Controllers\Watchdogs;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AvailabilityHistoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $err = 200;
        $res = Cache::get('api.entreprise.watchdogs.availability_history', function () {
            return Cache::rememberForever('api.entreprise.watchdogs.availability_history', function () {
                $client = new Client(); //GuzzleHttp\Client

                try {
                    $response = $client->get('https://dashboard.entreprise.api.gouv.fr/api/watchdoge/dashboard/availability_history');
                } catch (\GuzzleHttp\Exception\ServerException $e) {
                    $err = $e->getCode();

                    return json_decode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody()->getContents(), true);
            });
        });

        return response()->json($res, $err);
    }
}
