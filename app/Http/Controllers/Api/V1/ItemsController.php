<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

use App\Domain;
use App\ProductCategory as Category;
use App\Product;
use App\ProductHistory;
use App\Item;
use App\User;

/**
 * @resource Item (Products to be tracked.)
 * This api will be called in chrome extension to manage tracking. Middelware : JWT Authentication
 */
class ItemsController extends Controller
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
     * Watched Products Browsing API
     * This api will be called in chrome extension to get all of products tracked by authorized user.
     */
    public function index(Request $request) {
        $user = $request->input('user');
        $items = $user->items;

        return Response::json([
            'status' => true,
            'items' => $items
        ]);
    }


    /**
     * Watched Product Detail API
     * This api will be called in chrome extension to get a specific product with change histories being tracked by the authorized user.
     */
    public function get(Request $request) {
        $item_id = $request->input('id');
        $item = Item::where(['id' => $item_id])->first();
        $product = $item->product->with('histories');

        return Response::json([
            'status' => true,
            'product' => $product
        ]);
    }


    /**
     * Product watch API
     * This api will be called in chrome extension to track a new product by the authorized user.
     */
    public function add(Request $request) {
        $user = $request->input('user');
        $domain = $request->input('domain');
        $category = Category::firstOrCreate(['category_name' => 'Book']);
        if (empty($domain)) {
            $domain = "amazon.com";
        }
        $domain = Domain::firstOrCreate(['name' => $domain]);

        $productParams = $request->only('title', 'asin');
        $product = Product::firstOrNew([
            'domain_id' => $domain->id,
            'asin' => $request->input('asin')
        ]);
        $product->category_id = $category->id;
        $product->title = $request->input('title');
        $product->save();

        $history = new ProductHistory;
        $history->product_id=  $product->id;
        $history->bsr = $request->input('bsr');
        $history->currency = $request->input('currency');
        $history->price = $request->input('price');
        $history->est = $request->input('est');

        $item = Item::firstOrNew([
            'product_id' => $product->id,
            'tracked_by' => $user->id
        ]);
        $item->caption = $request->input('caption') || "No camption";

        if ($history->save() && $item->save()) {
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

    /**
     *  Product unwatch API
     *  This api will be called in chrome extension in case of that the authenticated user doesn't need to track the product any more.
     */
    public function del(Request $request) {
        $user = $request->input('user');
        $item_id = $request->input('id');
        $item = Item::where([
            'id' => $item_id,
            'tracked_by' => $user->id
        ])->first();

        if (is_null($item)) {
            return Response::json([
                'status' => false,
                'Result not found.'
            ]);
        } else {
            if ($item->delete()) {
                return Response::json([
                    'status' => true,
                    'message' => "Successfully removed."
                ]);
            } else {
                return Response::json([
                    'status' => false,
                    'message' => "Something went wrong in SQL."
                ]);
            }
        }
    }
}
