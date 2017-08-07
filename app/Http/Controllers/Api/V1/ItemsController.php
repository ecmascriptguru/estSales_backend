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
        $productID = $request->input('id');
        $user = $request->input('user');
        $item = Item::where([
            'product_id' => $productID,
            'tracked_by' => $user->id
        ])->first();

        if ($item) {
            $product = $item->product;
            $histories = $product->histories;

            return Response::json([
                'status' => true,
                'product' => $product,
                'histories' => $histories
            ]);
        } else {
            return Response::json([
                'status' => false,
                'product' => null,
                'histories' => null
            ]);
        }
    }


    /**
     * Product watch API
     * This api will be called in chrome extension to track a new product by the authorized user.
     */
    public function add(Request $request) {
        $user = $request->input('user');

        $items = $user->items;
        $trackingCount = sizeof($items);
        $membership = $user->membership_tier;
        $exp_at = $user->exp_at;

        if ($membership == "p") { // For pro membership
            if ($trackingCount > 49) {
                return Response::json([
                    'status' => false,
                    'message' => "Your current subscription only allows for tracking up to 50 books at a time."
                ]);
            }
        } elseif ($membership == "t" || $membership == "l") {
            if ($trackingCount > 9) {
                return Response::json([
                    'status' => false,
                    'message' => "Your current subscription only allows for tracking up to 10 books at a time."
                ]);
            }
        }

        $domain = $request->input('domain');
        $category = $request->input('category');
        if ($category == "") {
            $category = "Books";
        }
        $category = Category::firstOrCreate(['category_name' => $category]);
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
        
        $history = ProductHistory::firstOrCreate([
            'product_id' => $product->id,
            'bsr' => $request->input('bsr'),
            'currency' => $request->input('currency'),
            'price' => $request->input('price'),
            'est' => $request->input('est'),
            'pages' => $request->input('pages'),
            'monthly_rev' => $request->input('monthly_rev'),
            'reviews' => $request->input('reviews'),
        ]);

        $item = Item::firstOrNew([
            'product_id' => $product->id,
            'tracked_by' => $user->id
        ]);
        $item->caption = ($request->input('caption')) ? $request->input('caption') : "No camption";
        $item->product;

        if ($history->save() && $item->save()) {
            return Response::json([
                'status' => true,
                'id' => $item->id,
                'item' => $item,
                'product' => $product,
                'histories' => $product->histories
            ]);
        } else {
            return Response::json([
                'status' => false,
                'message' => "Error occured in SQL."
            ]);
        }
    }

    /**
     *  Product unwatch API
     *  This api will be called in chrome extension in case of that the authenticated user doesn't need to track the product any more.
     */
    public function del(Request $request) {
        $user = $request->input('user');
        $product_id = $request->input('id');
        $item = Item::where([
            'product_id' => $product_id,
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
