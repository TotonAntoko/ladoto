<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $categoryMenu = Category::orderBy('category_name','asc')->get();
        // $users = User::orderBy('id','desc')->paginate(5);
        // return view('admin.customer', compact('users','categoryMenu'));
        return view('admin.customer');
    }

    public function loadData(){
        $customer = User::all();
 
        return Datatables::of($customer)
            ->addColumn('action', function($customer){
                return //'<a href="" class="btn btn-success btn-xs">Active</a> '.
                        //'<a href="" class="btn btn-warning btn-xs">Suspend</a> '.
                        '<a onclick="showForm('. $customer->id .')" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> ' .
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        // $input['photo'] = null;

        // if ($request->hasFile('photo')){
        //     $input['photo'] = '/upload/photo/'.str_slug($input['name'], '-').'.'.$request->photo->getClientOriginalExtension();
        //     $request->photo->move(public_path('/upload/photo/'), $input['photo']);
        // }

        User::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Contact Created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $contact = User::findOrFail($id);
        return $contact;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $contact = User::findOrFail($id);
        return $contact;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $contact = User::findOrFail($id);


        $contact->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Contact Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $id = $request->input('id');

        // $cust = User::find($id);
        // $cust->delete();

        // return response()->json($cust);

        $contact = User::findOrFail($id);

        // if (!$contact->photo == NULL){
        //     unlink(public_path($contact->photo));
        // }

        User::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Contact Deleted'
        ]);
        
    }
}
