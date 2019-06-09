<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Brands;
use App\Images;
use App\Product;

use Intervention\Image\Facades\Image;
use Yajra\DataTables\DataTables;
use App\Transformers\BrandTransformer;

use Auth;


class BrandController extends Controller
{
    public function index(){
        return view('admin.brand');
    }

    public function loadData()
    {
        $contact = Brands::all();
 
        return Datatables::of($contact)
            ->addColumn('show_photo', function($contact){
                if ($contact->thumbs == NULL){
                    return 'No Image';
                }
                return $contact->thumbs;
            })
            // ->addColumn('category_name', function($contact){
            //     return $contact->categories->category_name;
            // })
            // ->addColumn('hargaProduk', function($contact){
            //     return 'Rp. '.number_format($contact->product_price);
            // })
            ->addColumn('action', function($contact){
                return '<a onclick="showForm('. $contact->id .')" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> ' .
                       '<a onclick="editForm('. $contact->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                       '<a onclick="deleteData('. $contact->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['show_photo','action'])->make(true);
    }

    public function store(Request $request)
    {
        //
        $this->validate($request,
            [
                'name'      => 'required',
                'email'     => 'required|email|unique:brands',
                'password'  => 'required|min:8',
                "img" => "required"
            ]);
        // dd($request->file("img"));

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $input['api_token'] = bcrypt($request->api_token);
        $brand = Brands::create($input);


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
                $input["imageable_id"] = $brand->id;
                $input["imageable_type"] = "App\Brands";


                $imgs[] = $image_name;
                Images::create($input);
            }
        }
        // Session::flash("status", 1);
        // return redirect()->route('admin-products.index');
        return response()->json([
            'success' => true,
            'message' => 'Brand Created'
        ]);
    }

    public function edit($id)
    {
        //
        // $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        // $categoriess = Category::pluck("category_name", "id")->all();
        // $products = Product::find($id);
        // return view("admin.products-edit", compact('categoriess', 'products', 'categoryMenu'));
        $contact = Brands::findOrFail($id);
        return $contact;
    }

    public function update(Request $request)
    {
        //
        // $this->validate($request,
        //     [

        //         "product_detail" => "required",
        //         "original_price" => "required|numeric",
        //         "product_price" => "required|numeric"

        //     ]);
        $id = $request->input('id');
        $products = Brands::find($id);

        $input = $request->only('name', 'email', 'password');
        // $input = $request->only('category_id', 'product_name', 'product_detail', 'original_price');
        if($request->password == 'password'){
            $input['password'] = $products->password;
        }else{
            $input['password'] = bcrypt($request->password);
        }
        
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
            'message' => 'Brands Updated'
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $products = Product::where('brand_id', $id)->get();

        foreach ($products as $product) {
            foreach ($product->images as $image) {
                unlink(public_path("uploads/" . $image->name));
                unlink(public_path("uploads/thumb_" . $image->name));
            }
            Images::where("imageable_id", $product->id)->where("imageable_type", "App\Product")->delete();
        }


        $img = Images::where('imageable_id', $id)->get();
        foreach ($img as $im) {
            @unlink(public_path("uploads/" . $im->name));
            @unlink(public_path("uploads/thumb_" . $im->name));
        }

        Images::where("imageable_id", $id)->where("imageable_type", "App\Brands")->delete();

        $products = Brands::destroy($id);

        // Session::flash("status", 1);

        // return redirect()->route('admin-products.index');
        // return response()->json($products);
        return response()->json([
            'success' => true,
            'message' => 'Contact Deleted'
        ]);

    }




    
    // API
    public function register(Request $request, Brands $brand, Images $image)
    {
        $this->validate($request, [
            'img'      => 'required',
            'name'      => 'required',
            'email'     => 'required|email|unique:brands',
            'password'  => 'required|min:8',
        ]);

        $brands = $brand->create([
            // 'id'        => $request->id,
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'api_token' => bcrypt($request->email),
        ]);

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
                $input["imageable_id"] = $brands->id;
                $input["imageable_type"] = "App\Brands";


                $imgs[] = $image_name;
                // Images::create($input);
                $image->create([
                    // 'id'        => $request->id,
                    'name'              => $image_name,
                    'imageable_id'      => $brands->id,
                    'imageable_type'    => "App\Brands",
                    // 'api_token' => bcrypt($request->email),
                ]);
            }
        }

        $response = fractal()
            ->item($brands)
            ->transformWith(new BrandTransformer)
            ->addMeta([
                'token' => $brands->api_token
                // 'image' => $image->name
            ])
            ->toArray();

        return response()->json($response, 201);
    }

    public function login(Request $request, Brands $brand)
    {
        
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return response()->json(['error' => 'Your Credentiall Is Wrong'], 401);
        }

        // return response()->json($request->password);

        $brand = $brand->find(Auth::user()->id);

        return fractal()
            ->item($brand)
            ->transformWith(new BrandTransformer)
            ->addMeta([
                'token' => $brand->api_token
            ])
            ->toArray();
    }
    
    public function allBrand(Brands $brand){
        $brand = $brand->find(Auth::user()->id);
        
        // return response()->json($brand);
        return fractal()
            ->item($brand)
            ->transformWith(new BrandTransformer)
            ->includeProducts()
            ->toArray();
    }

    public function allBrandById(Brands $brand, $id){
        $brand = $brand->find($id);
        
        // return response()->json($brand);
        return fractal()
            ->item($brand)
            ->transformWith(new BrandTransformer)
            ->includeProducts()
            ->toArray();
    }
}
