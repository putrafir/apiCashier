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
        return Pesanans::with('keranjangs.products')->get();
    }
    public function store(Request $request)
    {
        $pesanan = Pesanans::create([
            'keranjang_id' => $request->keranjang_id,
            'total_bayar' => $request->total_bayar,
        ]);

        return response()->json($pesanan, 201);
    }

    public function show($id)
    {
        $pesanan = Pesanans::with('keranjangs.products.categories')->findOrFail($id);

        return response()->json([
            'total_bayar' => $pesanan->total_bayar,
            'menus' => $pesanan->keranjangs->map(fn($item) => [
                'jumlah' => $item->jumlah,
                'total_harga' => $item->total_harga,
                'product' => $item->products->only(['id', 'kode', 'nama', 'harga', 'is_ready', 'gambar']) + [
                    'category' => $item->products->categories->only(['id', 'nama']),
                ],
            ]),
        ]);
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
