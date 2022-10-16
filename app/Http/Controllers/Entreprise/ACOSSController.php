<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ACOSSController extends Controller
{
    public function index($siren)
    {
        if (!$res = Cache::get("{$siren}.get_acoss_status", false)) {
            $now = date('mY');

            if (!Storage::disk('public')->exists("{$siren}/{$now}/acoss.pdf")) {
                try {
                    $response = $this->client->get('urssaf/unites_legales/' . $siren . '/attestation_vigilance');
                    $res      = json_decode($response->getBody()->getContents(), true);
                } catch (\GuzzleHttp\Exception\ClientException | \GuzzleHttp\Exception\ServerException  $e) {
                    return response()->json(json_decode($e->getResponse()->getBody()->getContents(), true), $e->getCode());
                }

                try {
                    $documentUrl  = data_get($res, 'data.document_url');
                    $uploadedFile = (new Client())->request('GET', $documentUrl);
                    Storage::disk('public')->put("{$siren}/{$now}/acoss.pdf", $uploadedFile->getBody());
                } catch (\GuzzleHttp\Exception\ClientException | \GuzzleHttp\Exception\ServerException  $e) {
                    return response()->json(json_decode($e->getResponse()->getBody()->getContents(), true), $e->getCode());
                }
            }

            Cache::put("{$siren}.get_acoss_status", response()->json(['url' => Storage::disk('public')->url("{$siren}/{$now}/acoss.pdf")]), 28800);

            $res = Cache::get("{$siren}.get_acoss_status");
        }

        return $res;
    }
}
