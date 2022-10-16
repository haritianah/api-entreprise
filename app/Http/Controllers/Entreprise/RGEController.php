<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class RGEController extends Controller
{
    public function index($siret)
    {
        if (!$res = Cache::get("{$siret}.get_rge_status")) {
            $res = Cache::remember("{$siret}.get_rge_status", 900, function () use ($siret) {
                try {
                    $response = $this->client->get('ademe/etablissements/' . $siret . '/certification_rge');
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return json_encode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }
}
