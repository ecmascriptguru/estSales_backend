<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

use App\Domain;
use App\Sample;

/**
 * @resource Sample
 * This api will be called in landing page to store new samples given by customers. Middelware : CSRF Token Verification
 * Also this will be used to building corpus for machine learning.
 */
class SamplesController extends Controller
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
     * Add new Sample API
     * This api will be called in landing page.
     */
    public function add(Request $request) {
        $domain = $request->input('domain');
        $bsr = $request->input('bsr');
        $sales = $request->input('sales');

        $domain = Domain::firstOrCreate(['name' => $domain]);
        $sample = Sample::firstOrNew([
            'domain_id' => $domain->id,
            'bsr' => $bsr,
            'sales' => $sales
        ]);

        if ($sample->save()) {
            return Response::json([
                'status' => true,
                'id' => $sample->id
            ]);
        } else {
            return Response::json([
                'status' => false,
                'msg' => "something went wrong."
            ]);
        }
    }
}
