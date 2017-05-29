<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\Domain;

class ISamplesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('ajax_samples');
    }

    public function ajax_samples(Request $request) {
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
                'status' => true,
                'samples' => $domain->initialSamples
            ]);
        }
    }
}
