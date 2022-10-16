<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class QUALIBATController extends Controller
{
    public function index($siret)
    {
        if (!$res = Cache::get("{$siret}.get_qualibat")) {
            $res = Cache::rememberForever("{$siret}.get_qualibat", function () use ($siret) {
                try {
                    $response = $this->client->get('qualibat/etablissements/' . $siret . '/certification_batiment');
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return json_encode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }
}
