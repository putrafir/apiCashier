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

        return Keranjangs::with('product')->get();
    }

    public function store(Request $request)
    {
        $keranjang = Keranjangs::create($request->all());
        return response()->json($keranjang, 201);
    }

    public function show($id)
    {

        $keranjang = Keranjangs::with('products.categories')->find($id);
        return response()->json([
            'jumlah' => $keranjang->jumlah,
            'total_harga' => $keranjang->total_harga,
            'product' => $keranjang->product->toArray(),
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
