<?php

namespace App\Http\Controllers;

use GraphQL\GraphQL;
use Illuminate\Http\Request;

class TestController extends Controller
{
//    simple test for how use graphQL with API REST

    public function testing(Request $request)
    {
        return view('welcome');
    }
}
