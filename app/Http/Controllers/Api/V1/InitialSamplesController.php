<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\Controller;

use App\Domain;

/**
 * @resource InitialSample
 * This api will be used in chrome extension to manage initial data. Middelware : JWT Authentication
 */
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

    /**
     * Initial Sample Data Browsing API
     * This api will be called in chrome extension to get initial sample data to be used in coefficients correction.
     */
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
