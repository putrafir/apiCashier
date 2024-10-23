<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeranjangsRequest;
use App\Http\Requests\UpdateKeranjangsRequest;
use App\Models\Keranjangs;
use Illuminate\Http\Request;

class KeranjangsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Keranjangs::all();
    }

    public function store(Request $request)
    {


        $product = $request->input('product');

        $keranjang = Keranjangs::create([
            'product_name' => $product['nama'],
            'product_image' => $product['gambar'],
            'product_price' => $product['harga'],
            'jumlah' => $request->jumlah,
            'total_harga' => $request->total_harga,
        ]);

        return response()->json([
            'id' => $keranjang->id,
            'jumlah' => $keranjang->jumlah,
            'total_harga' => $keranjang->total_harga,
            'product' => $product
        ], 200);
    }

    public function show($id)
    {
        $keranjang = Keranjangs::with('products.categories')->find($id);
        return response()->json([
            'jumlah' => $keranjang->jumlah,
            'total_harga' => $keranjang->total_harga,
            'product' => $keranjang->products->toArray(),
            'id' => $keranjang->id
        ]);
    }

    public function update(Request $request, $id)
    {
        $keranjang = Keranjangs::findOrFail($id);
        $keranjang->update($request->all());
        return response()->json($keranjang, 200);
    }

    public function destroy($id)
    {
        Keranjangs::destroy($id);
        return response()->json(null, 204);
    }
}
