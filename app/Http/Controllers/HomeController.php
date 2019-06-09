<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Product;
use App\Brands;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categoryMenu = Category::orderBy('category_name','asc')->get();
        $products = Product::orderBy('id','desc')->get();
        $brand = Brands::orderBy('id', 'desc')->get();
        return view('index', compact( 'products','categoryMenu', 'brand'));
    }

    public function category($slug){
        $categoryMenu = Category::orderBy('category_name','asc')->get();
        $category = Category::where("slug",$slug)->first();
        $products = Product::with('categories')->where('category_id',$category->id)->get();
        return view('category-details', compact('category','products','categoryMenu'));
    }

    public function product($slug){
        $categoryMenu = Category::orderBy('category_name','asc')->get();
        $product = Product::where("slug",$slug)->first();
        $bcrumb = $product->categories()->distinct()->get();
        return view('product-detail', compact('product','bcrumb','categoryMenu'));
    }

    public function contact(){
        $categoryMenu = Category::orderBy('category_name','asc')->get();
        return view('contact', compact('categoryMenu'));
    }
}
