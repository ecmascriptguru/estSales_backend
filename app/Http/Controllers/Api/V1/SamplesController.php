<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Domain;
use App\Sample;

class SamplesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('jwt');
    }

    /**
     * @resource Samples
     */
    public function add(Request $request) {
        $domain = $request->input('domain');
        $bsr = $request->input('bsr');
        $sales = $request->input('sales');
    }
}
