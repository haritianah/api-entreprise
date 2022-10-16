<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class RNAController extends Controller
{
    public function index($siret)
    {
        if (!$res = Cache::get("{$siret}.get_associations")) {
            $res = Cache::rememberForever("{$siret}.get_associations", function () use ($siret) {
                try {
                    $response = $this->client->get('ministere_interieur/rna/associations/' . $siret);
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return json_encode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }
}
