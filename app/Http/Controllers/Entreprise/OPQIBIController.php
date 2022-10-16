<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class OPQIBIController extends Controller
{
    public function index($siret)
    {
        if (!$res = Cache::get("{$siret}.get_opqibi")) {
            $res = Cache::rememberForever("{$siret}.get_opqibi", function () use ($siret) {
                try {
                    $response = $this->client->get('opqibi/unites_legales/' . $siret . '/certification_ingenierie');
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return json_encode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }
}
