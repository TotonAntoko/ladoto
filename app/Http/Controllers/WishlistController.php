<?php

namespace App\Http\Controllers;

use App\Wishlist;
use App\WishlistProduct;
use App\Category;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categoryMenu = Category::orderBy('category_name','asc')->get();
        $categories = Category::orderBy('category_name','asc')->get();
        return view('wishlist', compact('categories','categoryMenu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


        /*$quantity = request('quantity');
        if ($quantity<1){
          abort(400);
        }*/
        $product = Product::find(request('id'));
        $cartItem = Cart::add($product->id, $product->product_name/*, $quantity*/, $product->product_price, ['slug' => $product->slug]);

        if (Auth::check()) {
            $active_wishlist_id = session('active_wishlist_id');
            if (!isset($active_wishlist_id)) {
                $active_wishlist = Wishlist::create([
                    'user_id' => Auth::id()
                ]);
                $active_wishlist = $active_wishlist->id;
                session()->put('active_wishlist_id', $active_wishlist_id);
            }

            WishlistProduct::updateOrCreate(
                ['wishlist_id' => $active_wishlist_id, 'product_id' => $product->id]/*,
                ['quantity' => $cartItem->qty, 'price' => $product->product_price, 'status' => 'Your orders have received.']*/
            );
        }
        return response()->json(['cartCount' => Cart::count()]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($rowid)
    {
        //
        if (Auth::check()) {
            $active_wishlist_id = session('active_wishlist_id');
            $cartItem = Cart::get($rowid);

            /*if (request('quantity') == 0)
                BasketProduct::where('basket_id', $active_basket_id)->where('product_id', $cartItem->id)
                    ->delete();
            else
                BasketProduct::where('basket_id', $active_basket_id)->where('product_id', $cartItem->id)
                    ->update(['quantity' => request('quantity')]);*/
        }

        Cart::update($rowid, request('quantity'));


        return response()->json(['success' => true]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        if (Auth::check()) {
            $active_wishlist_id = session('active_wishlist_id');
            WishlistProduct::where('wishlist_id', $active_wishlist_id)->delete();
        }

        Cart::destroy();

        return redirect()->route('wishlist');
    }
}
