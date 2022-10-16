<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProBTPController extends Controller
{
    public function attestation($siret)
    {
        if (!$res = Cache::get("{$siret}.get_probtp_attestation")) {
            $res = Cache::rememberForever("{$siret}.get_probtp_attestation", function () use ($siret) {
                $client = new Client(['base_uri' => 'https://entreprise.api.gouv.fr']);

                try {
                    $response = $this->client->get('probtp/etablissements/' . $siret . '/attestation_cotisations_retraite');
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    return response()->json(json_decode($e->getResponse()->getBody()->getContents(), true), $e->getCode());
                }

                $res         = json_decode($response->getBody(), true);
                $documentUrl = data_get($res, 'data.document_url');

                if ($documentUrl) {
                    try {
                        $uploadedFile = $client->request('GET', $documentUrl);
                    } catch (\GuzzleHttp\Exception\ClientException | \GuzzleHttp\Exception\ServerException  $e) {
                        return response()->json(json_decode($e->getResponse()->getBody()->getContents(), true), $e->getCode());
                    }

                    Storage::disk('public')->put("{$siret}/probtp.pdf", $uploadedFile->getBody());

                    return response()->json(['url' => Storage::disk('public')->url("{$siret}/probtp.pdf")], $uploadedFile->getStatusCode());
                }

                return response()->json($res->getBody()->getContents(), $res->getCodeStatut());
            });
        }

        return $res;
    }
}
