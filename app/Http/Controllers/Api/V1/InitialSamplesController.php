<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\Controller;

use App\Domain;

class InitialSamplesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function index(Request $request) {
        $domain = $request->input('domain');

        if (!isset($domain) || empty($domain)) {
            $domain = "amazon.com";
        }
        
        $domain = Domain::where('name', $domain)->first();

        if (sizeof($domain) == 0) {
            return Response::json([
                'status' => false,
                'message' => "Domain not found."
            ]);
        } else {
            return Response::json([
                'samples' => $domain->initialSamples
            ]);
        }
    }
}
