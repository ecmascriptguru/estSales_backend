<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\Controller;

use App\ProductCategory as Category;
use App\Product;
use App\Domain;
use App\ProductHistory;

/**
 * @resource Product
 * This api will be called in chrome extension to manage Products. Middelware : JWT Authentication
 * Also this will be used to building corpus for machine learning.
 */
class ProductsController extends Controller
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
     * Add new product API
     * This api will be called in chrome extension to add a new product into a sample data source for machine learning.
     */
    public function add(Request $request) {
        $domain = $request->input('domain');

        $category = Category::firstOrCreate(['category_name' => 'Book']);
        if (empty($domain)) {
            $domain = "amazon.com";
        }
        $domain = Domain::firstOrCreate(['name' => $domain]);

        $productParams = $request->only('title', 'asin');
        $product = Product::firstOrNew([
            'domain_id' => $domain->id,
            'asin' => $request->input('asin'),
            'isbn' => $request->input('isbn')
        ]);
        $product->category_id = $category->id;
        $product->title = $request->input('title');
        $product->img = $request->input('img');
        $product->url = $request->input('url');
        $product->save();

        $history = new ProductHistory;
        $history->product_id=  $product->id;
        $history->bsr = $request->input('bsr');
        $history->currency = $request->input('currency');
        $history->price = $request->input('price');
        $history->est = $request->input('est');
        
        $history->pages = $request->input('pages');
        $history->monthly_rev = $request->input('monthly_rev');
        $history->reviews = $request->input('reviews');

        if ($history->save()) {
            return Response::json([
                'status' => true,
                'id' => $product->id
            ]);
        } else {
            return Response::json([
                'status' => false,
                'msg' => "An error occured in SQL."
            ]);
        }
    }
}
