<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\Domain;
use App\ProductCategory as Category;
use App\InitialSample;

/**
 *  @resource Initial Sample : Frontend
 *  This will be used in front end page and API side. But don't forget to pass xsrf-token because this will be used in front end side.
 */
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

    /**
     * Front end API to get Initial sample data.
     *
     * This api is used to get initial samples stored in database according to selected domain. Also this data will be used in computing coefficients to calculate Unit Sales Estimation based on Best seller rank.
     */
    public function ajax_samples(Request $request) {
        $domain = $request->input('domain');
        $category = $request->input('category');

        if (!isset($domain) || empty($domain)) {
            $domain = "amazon.com";
        }
        
        $domain = Domain::where('name', $domain)->first();

        $category = Category::where(['category_name' => $category])->first();
        if (sizeof($category) < 1) {
            $category = Category::where(['category_name' => 'Book'])->first();
        }

        if (sizeof($domain) == 0) {
            return Response::json([
                'status' => false,
                'message' => "Domain not found."
            ]);
        } else {
            return Response::json([
                'domain' => $domain->name,
                'status' => true,
                'samples' => InitialSample::where([
                    'domain_id' => $domain->id,
                    'category_id' => $category->id
                ])->get()
            ]);
        }
    }
}
