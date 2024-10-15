<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePesanansRequest;
use App\Http\Requests\UpdatePesanansRequest;
use App\Models\Pesanans;
use Illuminate\Http\Request;

class PesanansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Pesanans::with('keranjang.product')->get();
    }

    public function store(Request $request)
    {
        $pesanan = Pesanans::create($request->all());
        return response()->json($pesanan, 201);
    }

    public function show($id)
    {
        return Pesanans::with('keranjang.product')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pesanans::findOrFail($id);
        $pesanan->update($request->all());
        return response()->json($pesanan, 200);
    }

    public function destroy($id)
    {
        Pesanans::destroy($id);
        return response()->json(null, 204);
    }
}
