<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\Controller;

use App\ProductCategory as Category;
use App\Product;
use App\Domain;
use App\ProductHistory;

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
     *  @resource Products
     *  Add a new product
     */
    public function add(Request $request) {
        $domain = $request->input('domain');
        $category = Category::firstOrCreate(['category_name' => 'Book']);
        if (empty($domain)) {
            $domain = "amazon.com";
        }
        $domain = Domain::firstOrCreate(['name' => $domain]);

        $productParams = $request->only('title', 'asin');
        $product = Product::firstOrCreate($productParams);

        $history = new ProductHistory;
        $history->product_id=  $product->id;
        $history->bsr = $request->input('bsr');
        $history->currency = $request->input('currency');
        $history->price = $request->input('price');
        $history->est = $request->input('est');

        if ($history->save()) {
            return Response::json([
                'status' => true,
                'id' => $history->id
            ]);
        } else {
            return Response::json([
                'status' => false,
                'msg' => "Error occured in SQL."
            ]);
        }
    }
}
