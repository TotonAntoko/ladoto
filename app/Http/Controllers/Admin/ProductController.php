<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Images;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        // $products = Product::orderBy('id', 'desc')->paginate(5);
        // return view('admin.product', compact('products', 'categoryMenu'));
        $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        return view('admin.product', compact('categoryMenu'));
    }

    public function loadData()
    {
        $contact = Product::all();
 
        return Datatables::of($contact)
            ->addColumn('show_photo', function($contact){
                if ($contact->thumbs == NULL){
                    return 'No Image';
                }
                return $contact->thumbs;
            })
            ->addColumn('category_name', function($contact){
                return $contact->categories->category_name;
            })
            ->addColumn('action', function($contact){
                return '<a onclick="showForm('. $contact->id .')" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> ' .
                       '<a onclick="editForm('. $contact->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                       '<a onclick="deleteData('. $contact->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['show_photo', 'action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        $categoriess = Category::pluck("category_name", "id")->all();
        $products = Product::pluck("product_name", "id")->all();
        return view("admin.products-create", compact('products', 'categoriess', 'categoryMenu'));
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
        $this->validate($request,
            [
                "category_id" => "required",
                "product_name" => "required",
                "product_detail" => "required",
                "original_price" => "required|numeric",
                "product_price" => "required|numeric",
                "stok" => "required|numeric",
                "img" => "required"
            ]);
        // dd($request->file("img"));

        $input = $request->only('category_id', 'product_name', 'product_detail', 'original_price', 'product_price', 'stok');

        $product = Product::create($input);


        $imgs = array();

        if ($files = $request->file("img")) {
            foreach ($files as $file) {
                $rand = rand(1, 999999);
                $image_name = $rand . "." . $file->getClientOriginalExtension();
                $thumb = "thumb_" . $rand . "." . $file->getClientOriginalExtension();

                Image::make($file->getRealPath())->resize(454, 527)->save(public_path("uploads/" . $image_name));
                Image::make($file->getRealPath())->resize(235, 235)->save(public_path("uploads/" . $thumb));

                $input = [];
                $input["name"] = $image_name;
                $input["imageable_id"] = $product->id;
                $input["imageable_type"] = "App\Product";


                $imgs[] = $image_name;
                Images::create($input);
            }
        }
        // Session::flash("status", 1);
        // return redirect()->route('admin-products.index');
        return response()->json([
            'success' => true,
            'message' => 'Contact Created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Product::findOrFail($id);
        $contact['img'] = $contact->thumbs;
        $contact['kategori'] = $contact->categories->category_name; 
        $contact['hargaOri'] = number_format($contact->original_price);
        $contact['hargaProduct'] = number_format($contact->product_price);
        
        return $contact;
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
        // $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        // $categoriess = Category::pluck("category_name", "id")->all();
        // $products = Product::find($id);
        // return view("admin.products-edit", compact('categoriess', 'products', 'categoryMenu'));
        $contact = Product::findOrFail($id);
        return $contact;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        // $this->validate($request,
        //     [

        //         "product_detail" => "required",
        //         "original_price" => "required|numeric",
        //         "product_price" => "required|numeric"

        //     ]);
        $input = $request->only('category_id', 'product_name', 'product_detail', 'original_price', 'product_price', 'stok');
        // $input = $request->only('category_id', 'product_name', 'product_detail', 'original_price');
        $id = $request->input('id');
        $products = Product::find($id);
        $products->update($input);

        // echo('TOTON DWI ANTOKO');

        $imgs = array();

        if ($files = $request->file("img")) {
            foreach ($products->images as $product) {
                $image_name = $product->name;
                $thumb = "thumb_" . $product->name;
                foreach ($files as $file) {
                    Image::make($file->getRealPath())->resize(454, 527)->save(public_path("uploads/" . $image_name));
                    Image::make($file->getRealPath())->resize(235, 235)->save(public_path("uploads/" . $thumb));
                }

                $imgs[] = $image_name;

            }
        }

        // Session::flash("status", 1);
        // // return redirect()->route('admin-products.index');
        // return response()->json($products);
        return response()->json([
            'success' => true,
            'message' => 'Contact Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // $id = $request->input('id');
        //
        $img = Images::where('imageable_id', $id)->get();
        foreach ($img as $im) {
            @unlink(public_path("uploads/" . $im->name));
            @unlink(public_path("uploads/thumb_" . $im->name));
        }

        Images::where("imageable_id", $id)->where("imageable_type", "App\Product")->delete();

        $products = Product::destroy($id);

        // Session::flash("status", 1);

        // return redirect()->route('admin-products.index');
        // return response()->json($products);
        return response()->json([
            'success' => true,
            'message' => 'Contact Deleted'
        ]);

    }
}
