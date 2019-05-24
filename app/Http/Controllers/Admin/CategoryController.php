<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Images;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
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
        // $categories = Category::orderBy('id', 'desc')->paginate(5);
        // return view('admin.category', compact('categories', 'categoryMenu'));
        return view('admin.category');
    }

    public function loadData(){
        $customer = Category::all();
 
        return Datatables::of($customer)
            ->addColumn('action', function($customer){
                return //'<a href="" class="btn btn-success btn-xs">Active</a> '.
                        //'<a href="" class="btn btn-warning btn-xs">Suspend</a> '.
                        //'<a onclick="showForm('. $customer->id .')" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> ' .
                       '<a onclick="editForm('. $customer->id .')" class="btn btn-primary btn-xs">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a> ' .
                       '<a onclick="deleteData('. $customer->id .')" class="btn btn-danger btn-xs">
                            <i class="glyphicon glyphicon-trash"></i> Delete
                        </a>';
            })
            ->rawColumns(['action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $categoryMenu = Category::orderBy('category_name', 'asc')->get();
        // $categories = Category::pluck('category_name', 'id')->all();
        // return view("admin.category-create", compact('categories', 'categoryMenu'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();

        Category::create($input);

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
        $contact = Category::findOrFail($id);
        return $contact;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $contact = Category::findOrFail($id);
        $input = ['category_name' => $request->category_name,
                'slug' => ""];

        $contact->update($input);
        $contact->save();

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
        //
        // $id = $request->input('id');

        $products = Product::where('category_id', $id)->get();

        foreach ($products as $product) {
            foreach ($product->images as $image) {
                unlink(public_path("uploads/" . $image->name));
                unlink(public_path("uploads/thumb_" . $image->name));
            }
            Images::where("imageable_id", $product->id)->where("imageable_type", "App\Product")->delete();
        }

        $category = Category::find($id);
        $category->allProducts()->detach();
        $category->delete();

        // Session::flash("status", 1);
        // return redirect()->route('admin-category.index');
        // return response()->json($category);
        return response()->json([
            'success' => true,
            'message' => 'Contact Deleted'
        ]);

        
    }
}
