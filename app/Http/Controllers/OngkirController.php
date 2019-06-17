<?php

namespace App\Http\Controllers;

use App\Category;
use App\Basket;
use App\view\ChartHistory;
use Illuminate\Http\Request;
use RajaOngkir;
use Auth;

class OngkirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $data = RajaOngkir::Provinsi()->all();
        // return response()->json($data);
        $categoryMenu = Category::orderBy('category_name','asc')->get();
        $categories = Category::orderBy('category_name','asc')->get();
        return view('ongkir', compact('categories','categoryMenu'));
    }

    public function loadKota(){
        $data = RajaOngkir::Kota()->all();
        return response()->json($data);
    }

    public function loadProvinsi(){
        $data = RajaOngkir::Provinsi()->all();
        return response()->json($data);
    }

    public function loadCityByIdProv($provinsi_id){
        $data = RajaOngkir::Kota()->byProvinsi($provinsi_id)->get();
        return response()->json($data);
    }

    public function cekOngkir($asal, $kab, $kurir, $berat){
        $data = RajaOngkir::Cost([
            'origin' 		=> $asal, // id kota asal
            'destination' 	=> $kab, // id kota tujuan
            'weight' 		=> $berat, // berat satuan gram
            'courier' 		=> $kurir, // kode kurir pengantar ( jne / tiki / pos )
        ])->get();
        return response()->json($data);
    }

    public function addOngkirToDb($ongkir){
        $basket = Basket::where('user_id', Auth::id());
        $input = ['ongkir' => $ongkir];
        $basket->update($input);

        $viewchart = ChartHistory::where('user_id', Auth::id())->get();
        // $basket->save();

        return response()->json($viewchart);

        // $contact = Category::findOrFail($id);
        // $input = ['category_name' => $request->category_name,
        //         'slug' => ""];

        // $contact->update($input);
        // $contact->save();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
