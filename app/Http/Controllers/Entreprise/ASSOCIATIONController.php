<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ASSOCIATIONController extends Controller
{
    public function index($siret)
    {
        if (!$res = Cache::get("{$siret}.get_docassociations")) {
            $res = Cache::rememberForever("{$siret}.get_docassociations", function () use ($siret) {
                try {
                    $response = $this->client->get('ministere_interieur/rna/associations/' . $siret . '/documents');
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return json_encode($e->getResponse()->getBody()->getContents());
                }

                return json_decode($response->getBody(), true);
            });
        }

        return $res;
    }
}
