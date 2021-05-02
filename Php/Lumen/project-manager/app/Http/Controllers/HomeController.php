<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function random(){
        return $this->str_random(32);
    }

    function str_random($length = 32)
    {
        return Str::random($length);
    }
}
