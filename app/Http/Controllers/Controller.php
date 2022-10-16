<?php

namespace App\Http\Controllers;

use App\Traits\HasClient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,HasClient;

    protected $endpointPath;

    public function __construct()
    {
        Cache::flush();
        $this->instantiateClient();
    }
}
