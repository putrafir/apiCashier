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
        // Ambil semua pesanan dengan keranjangs beserta data relasinya
        $pesanans = Pesanans::with('keranjangs.products.categories')->get();

        return response()->json(
            $pesanans->map(function ($pesanan) {
                // dd($pesanan->keranjangs());
                return [
                    'total_bayar' => $pesanan->total_bayar,
                    'menus' => $pesanan->keranjangs->map(function ($keranjang) {
                        return [
                            'jumlah' => $keranjang->jumlah,
                            'total_harga' => $keranjang->total_harga,
                            'product' => $keranjang->products->only(['id', 'kode', 'nama', 'harga', 'is_ready', 'gambar']) + [
                                'category' => $keranjang->products->categories->only(['id', 'nama']),
                            ],
                        ];
                    }),
                ];
            })
        );
    }


    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'keranjang_ids' => 'required|array',
            'keranjang_ids.*' => 'exists:keranjangs,id',
            'total_bayar' => 'required|numeric|min:0',
        ]);

        // Buat pesanan baru
        $pesanan = Pesanans::create([
            'total_bayar' => $validatedData['total_bayar'],
        ]);

        // Hubungkan keranjang-keranjang ke pesanan melalui tabel pivot
        $pesanan->keranjangs()->sync($validatedData['keranjang_ids']);

        return response()->json([
            'id' => $pesanan->id,
            'total_bayar' => $pesanan->total_bayar,
            'keranjang_ids' => $validatedData['keranjang_ids'],
        ], 201);
    }

    public function show($id)
    {
        $pesanan = Pesanans::with('keranjangs.products.categories')->findOrFail($id);

        return response()->json(
            $pesanan
            // [
            //     'total_bayar' => $pesanan->total_bayar,
            //     'menus' => $pesanan->keranjangs->map(fn($item) => [
            //         'jumlah' => $item->jumlah,
            //         'total_harga' => $item->total_harga,
            //         'product' => $item->products->only(['id', 'kode', 'nama', 'harga', 'is_ready', 'gambar']) + [
            //             'category' => $item->products->categories->only(['id', 'nama']),
            //         ],
            //     ]),
            // ]
        );
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
