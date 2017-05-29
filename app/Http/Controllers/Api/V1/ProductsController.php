<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\Controller;

use App\ProductCategory as Category;
use App\Product;

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

    }
}
